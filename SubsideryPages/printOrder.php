<?php
    session_start();
    include "../scripts/php/dbConnection.php";
    $id; $orderID; $userID; $gameID; $phoneNo; $address; $receivingCode; $recCodeValidationDate; $category; $introDate; $descriptionOfGame; $price;
    $username; $gamename; $email;
    $date = date('d/m/Y', time());
    $invoiceNo = mt_rand();
    if(empty($_REQUEST['id'])){
        if (!(empty($_SESSION['adminUsername']))){
            echo '<script>
                location.href = \'../adminIndex.php\';        
                </script>';
        }else{
            echo '<script>
                location.href = \'../login.php\';        
                </script>';
        }
    }else{
        $tempID = $_REQUEST['id'];
        $id = base64_decode($tempID);

        FetchOrderPrintableData();
    }


    function FetchOrderPrintableData(){
        global $con, $id, $orderID, $userID, $gameID, $phoneNo, $address, $receivingCode, $recCodeValidationDate, $username, $gamename, $email, $category, $introDate, $descriptionOfGame, $price;
        $querySelectOrders = "select * from orders where order_id = '$id'";
        $resultOrders = mysqli_query($con, $querySelectOrders);

        while ($row = mysqli_fetch_array($resultOrders)){
            $orderID = $row['order_id'];
            $userID = $row['user_id'];
            $gameID = $row['game_id'];
            $phoneNo = $row['phone_no'];
            $address = $row['address'];
            $receivingCode = $row['receiving_code'];
            $recCodeValidationDate = $row['code_validation_date'];
            
            $querySelectUser = "select user_name, email from users where user_id = '$userID'";
            $resultUser = mysqli_query($con, $querySelectUser);

            while ($uRow = mysqli_fetch_array($resultUser)){
                $username = $uRow['user_name'];
                $email = $uRow['email'];
            }

            $querySelectGame = "select * from games where game_id = '$gameID'";
            $resultGame = mysqli_query($con, $querySelectGame);

            while ($gRow = mysqli_fetch_array($resultGame)){
                $gamename = $gRow['game_name'];
                $category = $gRow['category'];
                $introDate = $gRow['date'];
                $descriptionOfGame = $gRow['description'];
                $price = $gRow['price'];
            }
        }
    }


    require('fpdf182/fpdf.php');
//A4 width: 219mm
//default margin: 10mm each side
//writeable horizontal: 219 - (10 * 2) = 189mm
    $pdf = new FPDF('p','mm','A4');

    $pdf->AddPage();

//Set font to arial, bold, 14pt
    $pdf->SetFont('Arial','B',14);
//Cell(width, height, border, endline, [align])
    $pdf->Cell(130, 5, 'Motion Gaming - Best Game Seller Brand', 1, 0);
    $pdf->Cell(59, 5, 'INVOICE', 1, 1); //End of Line in PDF
//Set font
    $pdf->SetFont('Arial', '', 12);
//Cells on new row
    $pdf->Cell(39, 5, '[Street Address]', 1, 0);
    $pdf->Cell(91, 5, 'In the middle of no where', 1, 0);
    $pdf->Cell(29.5, 5, 'Date', 1, 0);
    $pdf->Cell(29.5, 5, '['.$date.']', 1, 1);
//Cells on new row
    $pdf->Cell(39, 5, 'Phone', 1, 0);
    $pdf->Cell(91, 5, '[+923126509649]', 1, 0);
    $pdf->Cell(29.5, 5, 'Invoice #', 1, 0);
    $pdf->Cell(29.5, 5, '['.$invoiceNo.']', 1, 1);
//Cells on new row
    $pdf->Cell(39, 5, '[Country, Zip]', 1, 0);
    $pdf->Cell(91, 5, '[57000]', 1, 0);
    $pdf->Cell(29.5, 5, 'Customer ID', 1, 0);
    $pdf->Cell(29.5, 5, '['.$id.']', 1, 1);
//Cell on new Row for spacing
    $pdf->Cell(189, 10, '', 0, 1);
//Cell on new Row for spacing
    $pdf->Cell(94.5, 5, 'Bill To', 0, 1);
//Cell on new row
    $pdf->Cell(15, 5, '', 0, 0);
    $pdf->Cell(174, 5, '['.$username.']', 0, 1);
//Cell on new row
    $pdf->Cell(15, 5, '', 0, 0);
    $pdf->Cell(174, 5, '['.$email.']', 0, 1);
//Cell on new row
    $pdf->Cell(15, 5, '', 0, 0);
    $pdf->MultiCell(174, 5, '['.$address.']', 0, 1);
//Cell on new row
    $pdf->Cell(15, 5, '', 0, 0);
    $pdf->Cell(174, 5, '['.$phoneNo.']', 0, 1);
//Cell on new Row for spacing
    $pdf->Cell(174, 10, '', 0, 1);

//Set font
    $pdf->SetFont('Arial', 'B', 12);

//Cell Description Section of game.
    $pdf->Cell(130, 5, 'Product Description', 1, 0);
    $pdf->Cell(29.5, 5, 'Taxable', 1, 0);
    $pdf->Cell(29.5, 5, 'Amount', 1, 1);

//Set font
    $pdf->SetFont('Arial', '', 12);

//Cell Description Section of game.
    $pdf->Cell(32.5, 5, 'Game Name', 1, 0);
    $pdf->Cell(97.5, 5, ''.$gamename.'', 1, 0);
    $pdf->Cell(29.5, 5, '-', 1, 0);
    $pdf->Cell(29.5, 5, '-', 1, 1);   
//Cell Description Section of game.
    $pdf->Cell(32.5, 5, 'Category', 1, 0);
    $pdf->Cell(97.5, 5, '['.$category.']', 1, 0);
    $pdf->Cell(29.5, 5, '-', 1, 0);
    $pdf->Cell(29.5, 5, '-', 1, 1);  
//Cell Description Section of game.
    $pdf->Cell(32.5, 5, 'Intro Date', 1, 0);
    $pdf->Cell(97.5, 5, '['.$introDate.']', 1, 0);
    $pdf->Cell(29.5, 5, '-', 1, 0);
    $pdf->Cell(29.5, 5, '-', 1, 1);   
//Cell Description Section of game.
    $pdf->Cell(32.5, 5, 'Price', 1, 0);
    $pdf->Cell(97.5, 5, '', 1, 0);
    $pdf->Cell(29.5, 5, '-', 1, 0);
    $pdf->Cell(29.5, 5, ''.$price.'$', 1, 1);

//Cell on new Row for spacing
    $pdf->Cell(189, 10, 'Game Description:', 0, 1);
    
    $pdf->SetFont('Courier', 'I', 10);
    
    $pdf->MultiCell(189, 20, ''.$descriptionOfGame.'', 1, 1);

    $pdf->SetFont('Arial', '', 12);

//Cell on new Row for spacing
    $pdf->Cell(189, 10, 'Product Access Code: (Use this code to download this product from the website)', 1, 1);
    
    $pdf->SetFont('Courier', 'I', 10);

    $pdf->MultiCell(189, 10, '['.$receivingCode.']', 1, 1); 

    $pdf->SetFont('Arial', '', 12);
    
    $pdf->Cell(43, 10, 'Code is valid upto:', 0, 0); 
    $pdf->Cell(83, 10, '['.$recCodeValidationDate.']', 0, 0); 
    $pdf->SetFont('Arial', '', 6);
    $pdf->Cell(63, 10, '              @UnKnowN', 0, 1); 

//Generate Output pdf
    $pdf->Output();
?>