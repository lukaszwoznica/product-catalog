<?php
    require_once("session.php");
    require_once("vendor/autoload.php" );
    require_once("user_class.php");
    use Dompdf\Dompdf;

    $user = new User();
    $dompdf = new Dompdf();

    $content = '
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
        html {
            font-family: DejaVu Sans;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 18px;
        }

        td, th {
            border: 1px solid #bfbfbf;
            text-align: left;
            padding: 8px;
        }

        td:first-child { 
            width: 10%;
            text-align: center;
        }

        td:last-child {
            width: 20%;
        }

        tr:first-child th{
            background-color: #333333;
            color: white;
            border-color: #b3b3b3;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        tr:last-child td {
            background-color: #333333;
            color: white;
            border-color: #333333;
        }

        img {
            max-width: 80px;
            height: auto;
        }

        </style>

        <h1>Kosztorys</h1>

        <table>
                <tr>
                    <th></th>
                    <th>Nazwa produktu</th>
                    <th>Cena</th>
                    <th>Ilość</th>
                    <th>Wartość</th>
                </tr>';

    if (isset($_SESSION['user_session'])) {
        try {
            $stmt =  $user->runQuery("SELECT id, prod_img, prod_name, prod_price, quantity
                                FROM clipboard
                                INNER JOIN products ON clipboard.prod_id = products.prod_id
                                WHERE clipboard.user_id = :id");
            $stmt->bindParam(":id", $_SESSION['user_session']);
            $stmt->execute();
            $total = 0;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $content .=
                    '<tr>
                        <td><img src="'.$row['prod_img'].'"</td>
                        <td>'.$row['prod_name'].'</td>
                        <td>'.$row['prod_price'].' zł</td>
                        <td>'.$row['quantity'].'</td>
                        <td>'.number_format((float)$row['prod_price']*$row['quantity'], 2, '.', '').' zł</td>
                    </tr>';
                $total += $row['prod_price']*$row['quantity'];
            }
            $content .= '
            <tr>
                <td></td><td></td><td></td><td></td>
                <td>Łącznie: <strong>'.$total.' zł</strong></td>
            </tr>
            </table>';
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    $dompdf->loadHtml($content);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $dompdf->stream("1", array("Attachment"=>0));

?>

