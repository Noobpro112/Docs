<?php
$host = 'localhost';
$dbname = 'documents';
$username = 'root.Att';
$password = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $content = $_POST['content'];
        $title = $_POST['title'];
        $id = $_POST['id'];
        
        // Sanitize only the title
        $sanitizedTitle = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');

        if ($id) {
            // Update existing document
            $stmt = $pdo->prepare("UPDATE documents SET title = :title, content = :content WHERE id = :id");
            $stmt->execute([
                'title' => $sanitizedTitle,
                'content' => $content,
                'id' => $id
            ]);
            echo "Documento atualizado com sucesso!";
        } else {
            // Insert new document
            $stmt = $pdo->prepare("INSERT INTO documents (title, content) VALUES (:title, :content)");
            $stmt->execute([
                'title' => $sanitizedTitle,
                'content' => $content
            ]);
            echo $pdo->lastInsertId(); // Return the new document ID
        }
    } else {
        echo "Requisição inválida.";
    }
} catch(PDOException $e) {
    echo "Erro ao salvar o documento: " . $e->getMessage();
}
