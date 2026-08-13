<?php 

  namespace models;

  require_once '../../entities/library.php';

  use PDO;
  use entities\library as LibraryModel;

  class library {

    protected PDO $database;

    public function __construct(PDO $database){
      $this->database = $database;
    }

    public function create($library) {
      $library_id = $library->__get('library_id');
      $name = $library->__get('name');
      $is_active = $library->__get('is_active');

      $query = '
        INSERT INTO library (library_id, name, is_active)
        VALUES (:library_id, :name, :is_active);
      ';

      $stmt = $this->database->prepare($query);
      $stmt->bindValue(':library_id', $library_id, PDO::PARAM_STR);
      $stmt->bindValue(':name', $name, PDO::PARAM_STR);
      $stmt->bindValue(':is_active', $is_active, PDO::PARAM_BOOL);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function read(string $id) {
      
      $query = '
        SELECT library_id, name, is_active
        FROM library
        WHERE library_id = :id
        LIMIT 1
      ';

      $stmt = $this->database->prepare($query);

      $stmt->execute([
        ':id' => $id
      ]);

      $data = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$data) {
        return null;
      };

      return new \entities\library(
        library_id: $data['library_id'],
        name: $data['name'],
        is_active: (bool) $data['is_active'],
      );

    }

    public function update(\entities\library $library): bool {

        $query = '
            UPDATE library
            SET name = :name,
                is_active = :is_active
            WHERE library_id = :library_id
        ';

        $stmt = $this->database->prepare($query);

        return $stmt->execute([
            ':library_id' => $library->__get('library_id'),
            ':name' => $library->__get('name'),
            ':is_active' => $library->__get('is_active'),
        ]);
    }

    # delete
  }
?>