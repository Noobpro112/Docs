<?php
$host = 'localhost';
$dbname = 'documents';
$username = 'root.Att';
$password = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $document = null;

    if ($id) {
        $stmt = $pdo->prepare("SELECT * FROM documents WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $document = $stmt->fetch(PDO::FETCH_ASSOC);
    }
} catch(PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $document ? htmlspecialchars($document['title']) : 'Novo Documento'; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="toolbar">
        <input type="text" id="titleInput" placeholder="Título do documento" value="<?php echo $document ? htmlspecialchars($document['title']) : ''; ?>">
        <button id="boldBtn">N</button>
        <button id="italicBtn">I</button>
        <button id="underlineBtn">S</button>
        <button id="saveBtn">Salvar</button>
    </div>
    <div id="editor" contenteditable="true" data-document-id="<?php echo $id ? $id : ''; ?>">
        <?php echo $document ? $document['content'] : 'Comece a digitar aqui...'; ?>
    </div>

    <script src="js/script.js"></script>
</body>
</html>