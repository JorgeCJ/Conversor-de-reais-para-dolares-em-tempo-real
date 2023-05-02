<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor com cotação atual</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bungee+Inline&family=Caveat&family=Dancing+Script&family=Mynerve&family=Noto+Serif+Display:wght@300&family=Roboto+Mono:ital,wght@1,400;1,500;1,700&family=Roboto:ital,wght@0,400;0,500;0,700;1,500&family=Rubik+Iso&family=Sassy+Frass&family=Tilt+Prism&family=Vast+Shadow&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/style.css">
</head>

<body>
    <main>
        <h1>Conversor de Moedas</h1>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get">
            <label for="din">Quantidade R$: </label>
            <input type="number" name="din" id="din" step="0.01">
            <input type="submit" value="Converter">
        </form>

        <?php

        $incio = date("m-d-Y", strtotime("-7 days"));
        $fim = date("m-d-Y");

        $url = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\'' . $incio . '\'&@dataFinalCotacao=\'' . $fim . '\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';

        $dados = json_decode(file_get_contents($url), true);

        #var_dump($dados);

        $cotação = $dados["value"][0]["cotacaoCompra"];


        $real = $_REQUEST["din"] ?? 0;

        $dólar = $real / $cotação;

        $padrão = numfmt_create("pt-BR", NumberFormatter::CURRENCY);

        echo "<p> A cotação atual é de " . numfmt_format_currency($padrão, $cotação, "BRL") . ". Isto posto, o valor de " . numfmt_format_currency($padrão, $real, "BRL") . " equivale a <strong>" . numfmt_format_currency($padrão, $dólar, "USD") . ".</strong></p>";

        ?>
    </main>



</body>

</html>