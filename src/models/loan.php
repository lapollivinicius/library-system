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
          member_id, 
          member_name, 
          book_id, 
          book_title, 
          code, 
          loaned_at, 
          due_at, 
          returned_at,
          is_returned,
          is_active
        )
        VALUES (
          :loan_id, 
          :user_id, 
          :member_id, 
          :member_name, 
          :book_id, 
          :book_title, 
          :code, 
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
      'member_id'   => $loan->__get('member_id'),
      'member_name' => $loan->__get('member_name'),
      'book_id'     => $loan->__get('book_id'),
      'book_title'  => $loan->__get('book_title'),
      'code'        => $loan->__get('code'),
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
        SELECT *
        FROM loans
        WHERE code = :code
          AND user_id = :user_id
          AND is_returned = 0
          AND is_active = 1
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
      $data['member_id'],
      $data['member_name'],
      $data['book_id'],
      $data['book_title'],
      $data['code'],
      $data['loaned_at'],
      $data['due_at'],
      $data['returned_at'],
      $data['is_returned'],
      $data['is_active']
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

  public function search(string $user_id, ?string $search = '', int $limit = 10, int $offset = 0, string $sort = 'asc'): array
  {

    $sort = strtolower($sort);

    if (!in_array($sort, ['asc', 'desc'], true)) {
      $sort = 'asc';
    }

    $where = $search
      ? 'WHERE user_id = :user_id
        AND is_active = 1
        AND is_returned = 0
        AND (
          code LIKE :search
          OR book_title LIKE :search
          OR member_name LIKE :search
        )' 
      : 'WHERE user_id = :user_id
        AND is_active = 1
        AND is_returned = 0';

    $query = "
        SELECT *
        FROM loans
        {$where}
        ORDER BY member_name {$sort}
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
        $loan['member_id'],
        $loan['member_name'],
        $loan['book_id'],
        $loan['book_title'],
        $loan['code'],
        $loan['loaned_at'],
        $loan['due_at'],
        $loan['returned_at'],
        $loan['is_returned'],
        $loan['is_active']
      ),
      $data
    );
  }

  public function count(string $user_id, ?string $search = ''): int
  {
    $where = $search
      ? 'WHERE user_id = :user_id 
        AND is_active = 1 
        AND is_returned = 0 
        AND (
          code LIKE :search 
          OR book_title LIKE :search 
          OR member_name LIKE :search
        )'
      : 'WHERE user_id = :user_id 
        AND is_active = 1 
        AND is_returned = 0';

    $query = "
          SELECT COUNT(*)
          FROM loans
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

  
}
