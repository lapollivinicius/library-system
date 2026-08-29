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
          :is_active
        )
    ';

    $stmt = $this->database->prepare($query);

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
      'is_active'   => (bool) $loan->__get('is_active'),
    ]);
  }

  public function read(string $user_id, string $code): \entities\member|null
  {

    $query = "
        SELECT *
        FROM members
        WHERE code = :code
          AND user_id = :user_id
          AND is_active = 1
        LIMIT 1
      ";

    $stmt = $this->database->prepare($query);
    $stmt->execute([
      ':user_id' => $user_id,
      ':code'    => $code
    ]);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
      return null;
    }

    return new \entities\member(
      $data['member_id'],
      $data['user_id'],
      $data['code'],
      $data['name'],
      $data['email'],
      $data['phone'],
      $data['document'],
      $data['is_active']
    );
  }
  
  // public function update(string $user_id, \entities\member $loan): void
  // {
  //   $query = '
  //       UPDATE members SET
  //           name = :name,
  //           email = :email,
  //           phone = :phone,
  //           document = :document
  //       WHERE user_id = :user_id AND code = :code
  //   ';

  //   $stmt = $this->database->prepare($query);

  //   $stmt->execute([
  //     'user_id'    => $user_id,
  //     'name'    => $loan->__get('name'),
  //     'email'   => $loan->__get('email'),
  //     'phone'     => $loan->__get('phone'),
  //     'document'    => $loan->__get('document'),
  //     'code'     => $loan->__get('code'),
  //   ]);
  // }

  // public function delete(string $user_id, string $code): void
  // {
  //   $query = "
  //       DELETE FROM members
  //       WHERE code = :code
  //         AND user_id = :user_id
  //       LIMIT 1
  //   ";

  //   $stmt = $this->database->prepare($query);
  //   $stmt->execute([
  //     ':code' => $code,
  //     ':user_id' => $user_id
  //   ]);
  // }
  
  // public function find(string $user_id, Array $data): \entities\member|false
  // {

  //   $query = "
  //       SELECT member_id, user_id, code, name, email, phone, document, is_active
  //       FROM members
  //       WHERE user_id = :user_id
  //         AND is_active = 1
  //         AND (
  //             name = :name
  //             OR email = :email
  //         )
  //       LIMIT 1;
  //     ";

  //   $stmt = $this->database->prepare($query);
  //   $stmt->execute([
  //     ':user_id' => $user_id,
  //     ':name' => $data['name'],
  //     ':email' => $data['email'],
  //   ]);

  //   $data = $stmt->fetch(PDO::FETCH_ASSOC);

  //   if (!$data) {
  //     return false;
  //   }

  //   return new \entities\member(
  //     $data['member_id'],
  //     $data['user_id'],
  //     $data['code'],
  //     $data['name'],
  //     $data['email'],
  //     $data['phone'],
  //     $data['document'],
  //     $data['is_active']
  //   );
  // }

  public function search(string $user_id, ?string $search = '', int $limit = 10, int $offset = 0, string $sort = 'asc'): array
  {

    $sort = strtolower($sort);

    if (!in_array($sort, ['asc', 'desc'], true)) {
      $sort = 'asc';
    }

    $where = $search
    ? 'WHERE user_id = :user_id
       AND is_active = 1
       AND (
           code LIKE :search
           OR book_title LIKE :search
           OR member_name LIKE :search
       )'
    : 'WHERE user_id = :user_id
       AND is_active = 1';

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
        $loan['is_active']
      ),
      $data
    );
  }

  public function count(string $user_id, ?string $search = ''): int
  {
    $where = $search
      ? 'WHERE user_id = :user_id AND is_active = 1 AND (code LIKE :search OR book_title LIKE :search OR member_name LIKE :search)'
      : 'WHERE user_id = :user_id AND is_active = 1';

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
