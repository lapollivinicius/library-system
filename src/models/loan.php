<?php

namespace models;

use PDO;

class loan
{

  protected PDO $database;

  public function __construct(PDO $database)
  {
    $this->database = $database;
  }

  public function create(\entities\loan $loan): void
  {
    $query = '
        INSERT INTO loans (
          loan_id, 
          user_id, 
          code, 
          member_code, 
          book_code, 
          loaned_at, 
          due_at, 
          returned_at,
          is_returned,
          is_active
        )
        VALUES (
          :loan_id, 
          :user_id, 
          :code, 
          :member_code, 
          :book_code, 
          :loaned_at, 
          :due_at, 
          :returned_at,
          :is_returned,
          :is_active
        )
    ';

    $stmt = $this->database->prepare($query);

    $isReturned = $loan->__get('is_returned') ? 1 : 0;
    $isActive   = $loan->__get('is_active') ? 1 : 0;

    $stmt->execute([
      'loan_id'     => $loan->__get('loan_id'),
      'user_id'     => $loan->__get('user_id'),
      'code'        => $loan->__get('code'),
      'member_code'   => $loan->__get('member_code'),
      'book_code'     => $loan->__get('book_code'),
      'loaned_at'   => $loan->__get('loaned_at'),
      'due_at'      => $loan->__get('due_at'),
      'returned_at' => $loan->__get('returned_at'),
      'is_returned' => $isReturned,
      'is_active'   => $isActive,
    ]);
  }

  public function read(string $user_id, string $code): \entities\loan|null
  {
    $query = "
        SELECT
            l.loan_id,
            l.user_id,
            l.code,
            l.member_code,
            l.book_code,
            l.loaned_at,
            l.due_at,
            l.returned_at,
            l.is_returned,
            l.is_active,
            m.name AS member_name,
            b.title AS book_title
        FROM loans l

        INNER JOIN members m
            ON m.user_id = l.user_id
            AND m.code = l.member_code

        INNER JOIN books b
            ON b.user_id = l.user_id
            AND b.code = l.book_code

        WHERE l.code = :code
            AND l.user_id = :user_id
            AND l.is_returned = 0
            AND l.is_active = 1

        LIMIT 1
    ";

    $stmt = $this->database->prepare($query);

    $stmt->execute([
      ':user_id' => $user_id,
      ':code' => $code
    ]);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
      return null;
    }

    return new \entities\loan(
      $data['loan_id'],
      $data['user_id'],
      $data['code'],
      $data['member_code'],
      $data['book_code'],
      $data['loaned_at'],
      $data['due_at'],
      $data['returned_at'],
      $data['is_returned'],
      $data['is_active'],
      $data['member_name'],
      $data['book_title']
    );
  }

  public function update(string $user_id, \entities\loan $loan): void
  {
    $query = '
        UPDATE loans SET
            due_at = :due_at,
            returned_at = :returned_at,
            is_returned = :is_returned,
            is_active = :is_active
        WHERE user_id = :user_id AND code = :code
    ';

    $stmt = $this->database->prepare($query);

    $stmt->execute([
      'user_id'     => $user_id,
      'due_at'      => $loan->__get('due_at'),
      'returned_at' => $loan->__get('returned_at'),
      'is_returned' => $loan->__get('is_returned'),
      'is_active'   => $loan->__get('is_active'),
      'code'        => $loan->__get('code'),
    ]);
  }

  public function search(
    string $user_id,
    ?string $search = '',
    int $limit = 10,
    int $offset = 0,
    string $sort = 'asc'
  ): array {

    $sort = strtolower($sort);

    if (!in_array($sort, ['asc', 'desc'], true)) {
      $sort = 'asc';
    }

    $where = $search
      ? 'WHERE l.user_id = :user_id
           AND l.is_active = 1
           AND l.is_returned = 0
           AND (
               l.code LIKE :search
               OR b.title LIKE :search
               OR m.name LIKE :search
           )'
      : 'WHERE l.user_id = :user_id
           AND l.is_active = 1
           AND l.is_returned = 0';

    $query = "
        SELECT
            l.*,
            m.name AS member_name,
            b.title AS book_title
        FROM loans l

        INNER JOIN members m
            ON m.user_id = l.user_id
            AND m.code = l.member_code

        INNER JOIN books b
            ON b.user_id = l.user_id
            AND b.code = l.book_code

        {$where}

        ORDER BY l.due_at {$sort}

        LIMIT :limit OFFSET :offset
    ";

    $stmt = $this->database->prepare($query);

    if ($search) {
      $stmt->bindValue(':search', "%{$search}%", PDO::PARAM_STR);
    }

    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return array_map(
      fn(array $loan) => new \entities\loan(
        $loan['loan_id'],
        $loan['user_id'],
        $loan['code'],
        $loan['member_code'],
        $loan['book_code'],
        $loan['loaned_at'],
        $loan['due_at'],
        $loan['returned_at'],
        $loan['is_returned'],
        $loan['is_active'],
        $loan['member_name'],
        $loan['book_title']
      ),
      $data
    );
  }

  public function count(string $user_id, ?string $search = ''): int
  {
    $where = $search
      ? 'WHERE l.user_id = :user_id
           AND l.is_active = 1
           AND l.is_returned = 0
           AND (
               l.code LIKE :search
               OR b.title LIKE :search
               OR m.name LIKE :search
           )'
      : 'WHERE l.user_id = :user_id
           AND l.is_active = 1
           AND l.is_returned = 0';

    $query = "
        SELECT COUNT(*)
        FROM loans l

        INNER JOIN members m
            ON m.user_id = l.user_id
            AND m.code = l.member_code

        INNER JOIN books b
            ON b.user_id = l.user_id
            AND b.code = l.book_code

        {$where}
    ";

    $stmt = $this->database->prepare($query);

    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);

    if ($search) {
      $stmt->bindValue(':search', "%{$search}%", PDO::PARAM_STR);
    }

    $stmt->execute();

    return (int) $stmt->fetchColumn();
  }

  public function recent(string $user_id, int $limit = 3): array
  {
    $query = '
        SELECT
            l.*,
            m.name AS member_name,
            b.title AS book_title
        FROM loans l

        INNER JOIN members m
            ON m.user_id = l.user_id
            AND m.code = l.member_code

        INNER JOIN books b
            ON b.user_id = l.user_id
            AND b.code = l.book_code

        WHERE l.user_id = :user_id
          AND is_returned = 0
          AND l.is_active = 1

        ORDER BY l.loaned_at DESC

        LIMIT :limit
    ';

    $stmt = $this->database->prepare($query);

    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);

    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return array_map(
      fn(array $loan) => new \entities\loan(
        $loan['loan_id'],
        $loan['user_id'],
        $loan['code'],
        $loan['member_code'],
        $loan['book_code'],
        $loan['loaned_at'],
        $loan['due_at'],
        $loan['returned_at'],
        $loan['is_returned'],
        $loan['is_active'],
        $loan['member_name'],
        $loan['book_title']
      ),
      $data
    );
  }

}
