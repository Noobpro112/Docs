<?php
$host = 'localhost';
$dbname = 'documents';
$username = 'root.Att';
$password = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT id, title FROM documents ORDER BY updated_at DESC");
    $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Documentos</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Meus Documentos</h1>
    <ul id="document-list">
        <?php foreach ($documents as $doc): ?>
            <li>
                <a href="editor.php?id=<?php echo $doc['id']; ?>">
                    <?php echo htmlspecialchars($doc['title']); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="editor.php" class="new-doc-btn">Criar Novo Documento</a>
</body>
</html>