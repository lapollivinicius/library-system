<?php

namespace models;

use PDO;

class member
{

  protected PDO $database;

  public function __construct(PDO $database)
  {
    $this->database = $database;
  }

  
  public function create(\entities\member $member): void
  {
    $query = '
        INSERT INTO members (member_id, user_id, code, name, email, phone, document, is_active)
        VALUES (:member_id, :user_id, :code, :name, :email, :phone, :document, :is_active)
    ';

    $stmt = $this->database->prepare($query);

    $stmt->execute([
      'member_id' => $member->__get('member_id'),
      'user_id'   => $member->__get('user_id'),
      'code'      => $member->__get('code'),
      'name'      => $member->__get('name'),
      'email'     => $member->__get('email'),
      'phone'     => $member->__get('phone'),
      'document'  => $member->__get('document'),
      'is_active' => (bool) $member->__get('is_active'),
    ]);
  }

  public function read(string $user_id, string $code): \entities\member|null
  {

    $query = "
        SELECT member_id, user_id, code, name, email, phone, document, is_active
        FROM members
        WHERE code = :code
          AND user_id = :user_id
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
  
  public function update(string $user_id, \entities\member $member): void
  {
    $query = '
        UPDATE members SET
            name = :name,
            email = :email,
            phone = :phone,
            document = :document
        WHERE user_id = :user_id AND code = :code
    ';

    $stmt = $this->database->prepare($query);

    $stmt->execute([
      'user_id'    => $user_id,
      'name'    => $member->__get('name'),
      'email'   => $member->__get('email'),
      'phone'     => $member->__get('phone'),
      'document'    => $member->__get('document'),
      'code'     => $member->__get('code'),
    ]);
  }

  public function delete(string $user_id, string $code): void
  {
    $query = "
        DELETE FROM members
        WHERE code = :code
          AND user_id = :user_id
        LIMIT 1
    ";

    $stmt = $this->database->prepare($query);
    $stmt->execute([
      ':code' => $code,
      ':user_id' => $user_id
    ]);
  }
  
  public function find(string $user_id, Array $data): \entities\member|false
  {

    $query = "
        SELECT member_id, user_id, code, name, email, phone, document, is_active
        FROM members
        WHERE user_id = :user_id
          AND is_active = 1
          AND (
              name = :name
              OR email = :email
          )
        LIMIT 1;
      ";

    $stmt = $this->database->prepare($query);
    $stmt->execute([
      ':user_id' => $user_id,
      ':name' => $data['name'],
      ':email' => $data['email'],
    ]);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
      return false;
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

  public function search(string $user_id, ?string $name = '', int $limit = 10, int $offset = 0, string $sort = 'asc'): array
  {

    $sort = strtolower($sort);

    if (!in_array($sort, ['asc', 'desc'], true)) {
      $sort = 'asc';
    }

    $where = $name
      ? 'WHERE user_id = :user_id AND is_active = 1 AND name LIKE :name'
      : 'WHERE user_id = :user_id AND is_active = 1';

    $query = "
        SELECT *
        FROM members
        {$where}
        ORDER BY name {$sort}
        LIMIT :limit OFFSET :offset
    ";

    $stmt = $this->database->prepare($query);

    if ($name) {
      $stmt->bindValue(':name', "%{$name}%", PDO::PARAM_STR);
    }
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return array_map(
      fn(array $member) => new \entities\member(
        $member['member_id'],
        $member['user_id'],
        $member['code'],
        $member['name'],
        $member['email'],
        $member['phone'],
        $member['document'],
        $member['is_active']
      ),
      $data
    );
  }

  public function count(string $user_id, ?string $name = ''): int
  {
    $where = $name
      ? 'WHERE user_id = :user_id AND is_active = 1 AND name LIKE :name'
      : 'WHERE user_id = :user_id AND is_active = 1';

    $query = "
          SELECT COUNT(*)
          FROM members
          {$where}
    ";

    $stmt = $this->database->prepare($query);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    if ($name) {
      $stmt->bindValue(':name', "%{$name}%", PDO::PARAM_STR);
    }

    $stmt->execute();
    return (int) $stmt->fetchColumn();
  }


}
