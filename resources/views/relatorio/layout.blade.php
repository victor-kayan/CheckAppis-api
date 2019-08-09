<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Relatório BeeCheck</title>
    <link rel="shortcut icon" href="" />

    <style>
    .clearfix:after {
        content: "";
        display: table;
        clear: both;
        color: red
    }

    a {
        color: #5D6975;
        text-decoration: underline;
    }

    body {
        margin: 0 auto;
        color: #001028;
        background: #FFFFFF;
        font-family: Arial, sans-serif;
        font-size: 12px;
        font-family: Arial;
    }

    header {
        padding: 10px 0;
        margin-bottom: 30px;
    }

    #logo {
        text-align: center;
        margin-bottom: 20px;
        margin-top: 20px;
        font-size: 20pt
    }

    #span-bee {
        color: #FFD915
    }

    #span-check {
        color: #5D6975
    }

    #logo img {
        width: 90px;
    }

    h1 {
        border-top: 1px solid #C1CED9;
        border-bottom: 1px solid #C1CED9;
        color: #5D6975;
        font-size: 2.0em;
        line-height: 1.4em;
        font-weight: normal;
        text-align: center;
        margin: 0 0 20px 0;
        background: url(dimension.png);
    }

    #project {
        float: left;
    }

    #project span {
        color: #5D6975;
        text-align: right;
        width: 52px;
        margin-right: 10px;
        display: inline-block;
        font-size: 0.8em;
    }

    #company {
        float: right;
        text-align: right;
    }

    #project div,
    #company div {
        white-space: nowrap;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 20px;
    }

    table tr:nth-child(2n-1) td {
        background: #F5F5F5;
    }

    table tr {
        text-align: left
    }

    table th,
    table td {
        text-align: center;
    }

    table th {
        /* padding: 5px 20px; */
        color: #5D6975;
        border-bottom: 1px solid #C1CED9;
        white-space: nowrap;
        font-weight: normal;
        /* text-align: left; */
    }

    table .service,
    table {
        text-align: center;
        font-size: 9pt
    }

    table td {
        padding: 15px;
        text-align: center;
        font-size: 10pt
    }

    table td.service,
    table td.desc {
        vertical-align: top;
    }

    table td.unit,
    table td.qty,
    table td.total {
        font-size: 1.2em;
    }

    table td.grand {
        border-top: 1px solid #C1CED9;
        text-align: right
    }

    #notices .notice {
        color: #5D6975;
        font-size: 1.2em;
    }

    #observacao {
        font-size: 12pt;
        padding: 5px
    }

    footer {
        color: #5D6975;
        width: 100%;
        height: 5px;
        position: absolute;
        bottom: 0;
        border-top: 1px solid #C1CED9;
        padding: 8px 0;
        text-align: center;
    }
    </style>
</head>

<body>
    <header class="clearfix">
        <div id="logo">
            <span id="span-bee">Bee</span><span id="span-check">Check</span>
        </div>
        <h1>@yield('titleHeader')</h1>
    </header>
    <main>
        @yield('content')
    </main>
    <br />
    <footer>
        BeeCheck - Sistema de Gerenciamento de Colmeias e apiários.
    </footer>
</body>

</html>