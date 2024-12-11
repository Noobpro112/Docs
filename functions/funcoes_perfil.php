<?php
include_once(__DIR__ . "/../include/conexao.php");

function getProfilePicture() {
    global $conexao;

    if(!isset($_SESSION['usuario_id'])) {
        return "../../imgs/perfil_preto.png"; // Caminho partindo da pasta admin
    }

    $id_usuario = $_SESSION['usuario_id'];

    $query = "SELECT usuario_foto FROM tb_usuario WHERE id_usuario = ?";
    $stmt = $conexao->prepare($query);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if($row = $result->fetch_assoc()) {
        if($row['usuario_foto'] && strlen($row['usuario_foto']) > 0) {
            return "data:image/jpeg;base64," . base64_encode($row['usuario_foto']);
        }
    }

    return "../../imgs/perfil_preto.png"; // Caminho partindo da pasta admin
}