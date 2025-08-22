<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COINPEL - Bem-vindo</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: linear-gradient(0deg, rgba(108, 57, 122, 0.59) 0%, rgba(108, 57, 122, 0.59) 100%), url('{{ asset('images/Tumb.png') }}') lightgray 50% / cover no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
            overflow: hidden;
        }
        .center-content {
            display: flex;
            width: 100vw;
            height: 100vh;
            padding: 322px 1070px 321px 190px;
            align-items: flex-start;
            justify-content: flex-start;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 2;
            box-sizing: border-box;
        }
        .logo {
            width: 120px;
            height: 120px;
            margin-bottom: 20px;
        }
        .brand {
            color: #593E75;
            font-size: 4rem;
            font-weight: bold;
            letter-spacing: 2px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            margin: 0;
        }
        .loading-dots {
            color: #593E75;
            font-size: 2rem;
            margin-top: 20px;
            animation: blink 1.5s infinite;
        }
        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0.3; }
        }
    </style>
    <script>
        // Redireciona automaticamente após 5 segundos
        setTimeout(function() {
            window.location.href = '/login';
        }, 3000);
    </script>
