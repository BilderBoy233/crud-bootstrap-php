<?php

//mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);
$mysql = new mysqli_driver();
$mysql->report_mode = MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR;

function open_database()
{
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $conn->set_charset("utf8");
        return $conn;
    } catch (Exception $e) {
        throw new Exception("Erro ao conectar no Banco de dados:<br>{$e->getMessage()}");
    }
}

function close_database($conn)
{
    try {
        $conn->close();
    } catch (Exception $e) {
        throw new Exception("Erro ao fechar o Banco de dados:<br>{$e->getMessage()}");
    }
}

/**
 *  Pesquisa um Registro pelo ID em uma Tabela
 */
function find($table = null, $id = null)
{
    $database = open_database();
    $found = null;

    try {
        if ($id) {
            $sql = "SELECT * FROM $table WHERE id = $id";
            $result = $database->query($sql);

            if ($result->num_rows > 0) {
                $found = $result->fetch_assoc();
            }
        } else {
            $sql = "SELECT * FROM $table";
            $result = $database->query($sql);

            if ($result->num_rows > 0) {
                $found = [];
                while ($row = $result->fetch_assoc()) {
                    array_push($found, $row);
                }
            }
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->getMessage();
        $_SESSION['type'] = 'danger';
    }

    close_database($database);
    return $found;
}

/**
 *  Pesquisa Todos os Registros de uma Tabela
 */
function find_all($table)
{
    return find($table);
}

/**
 *  Insere um registro no BD
 */
function save($table = null, $data = null)
{
    $database = open_database();
    $columns = null;
    $values = null;

    foreach ($data as $key => $value) {
        $columns .= trim($key, "'") . ",";
        $values .= "'$value',";
    }

    $columns = rtrim($columns, ',');
    $values = rtrim($values, ',');

    $sql = "INSERT INTO " . $table . "($columns)" . " VALUES " . "($values);";

    try {
        $database->query($sql);
        $_SESSION['message'] = 'Registro cadastrado com sucesso.';
        $_SESSION['type'] = 'success';
    } catch (Exception $e) {
        $_SESSION['message'] = 'Não foi possível realizar a operação.';
        $_SESSION['type'] = 'danger';
    }

    close_database($database);
}

/**
 *  Atualiza um registro em uma tabela, por ID
 */
function update($table = null, $id = 0, $data = null)
{
    $database = open_database();
    $items = null;

    foreach ($data as $key => $value) {
        $items .= trim($key, "'") . "='$value',";
    }

    $items = rtrim($items, ',');

    $sql = "UPDATE " . $table;
    $sql .= " SET $items";
    $sql .= " WHERE id=" . $id . ";";

    try {
        $database->query($sql);
        $_SESSION['message'] = 'Registro atualizado com sucesso.';
        $_SESSION['type'] = 'success';
    } catch (Exception $e) {
        $_SESSION['message'] = 'Não foi possível realizar a operação.';
        $_SESSION['type'] = 'danger';
    }

    close_database($database);
}

/**
 *  Remove uma linha de uma tabela pelo ID do registro
 */
function remove($table = null, $id = null)
{
    $database = open_database();

    try {
        if ($id) {
            $sql = "DELETE FROM " . $table . " WHERE id = " . $id;
            $database->query($sql);

            $_SESSION['message'] = "Registro Removido com Sucesso.";
            $_SESSION['type'] = 'success';
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->getMessage();
        $_SESSION['type'] = 'danger';
    }

    close_database($database);
}

function filter($table = null, $p = null)
{
    $database = open_database();
    $found = null;

    try {
        if ($p) {
            $sql = "SELECT * FROM" . $table . " WHERE " . $p;
            $result = $database->query($sql);

            if ($result->num_rows > 0) {
                $found = array();
                while ($row = $result->fetch_assoc()) {
                    array_push($found, $row);
                }
            }else
            {
                throw new Exception("Nenhum registro encontrado.");
            }
        }
    } catch (Exception $e) {
        $_SESSION['message'] = "Erro: " . $e->getMessage();
        $_SESSION['type'] = 'danger';
    }

    close_database($database);
    return $found;
}

function criptografia($senha)
{

    $custo = "08";
    $salt = "Cf1f2f3f4f5f6f7f8f9g0h1i2j3k4l5m6n7o8p9q0r1s2t3u4v5w6x7y8z9A0B1C2D3E4F5G6H7I8J9K0L1M2N3O4P5Q6R7S8T9U0V1W2X3Y4Z5a6b7c8d9e0f1g2h3i4j5k6l7m8n9o0p1q2r3s4t5u6v7w8x9y0z1";
    $hash = crypt($senha, "$2a$" . $custo . "$" . $salt . "$");
    return $hash;
}
?>
