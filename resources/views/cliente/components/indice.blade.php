<style>
    .container {
        background-color: white;
        padding: 10px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        position: relative;
        margin: 1px auto;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e0e0e0;
    }

    .logo {
        width: 100px;
        height: 100px;
        overflow: hidden;
        border-radius: 50%;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .logo:hover {
        transform: scale(1.05);
    }

    .logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .journal-info {
        text-align: right;
        font-size: 14px;
        position: absolute;
        top: 2px;
        right: 4px;
        color: #555;
    }

    .journal-info div:first-child {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 5px;
        color: #333;
    }

    .author {
        margin-top: 1px;
        background-color: #f9f9f9;
        padding: 2px;
        border-radius: 10px;
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.05);
    }

    .author p {
        margin: 1px 0;
        font-size: 16px;
        color: #333;
    }

    .author p:first-child {
        font-size: 18px;
        color: #1a1a1a;
    }

    .email {
        color: #0013b9;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .email:hover {
        color: #000d7a;
        text-decoration: underline;
    }

    .date {
        font-weight: 600;
        color: #555;
        font-size: 14px;
    }
</style>

<div class="container">
    <div class="journal-info">
        <div>Reporte electrónico de los clientes</div>
        <div>
            <p class="date">
                Fecha: <?php echo date('d-m-Y'); ?>
            </p>
        </div>
    </div>
    <div class="header">
        <div class="logo">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSdI5h6LZxis-xvMA-mioIFBUdBqrofceIn1A&s"
                alt="Logo">
        </div>
    </div>
    <div class="author">
        @if (auth()->check())
            <div class="author">
                <p><strong>{{ auth()->user()->name }}</strong></p>
                <p><a href="mailto:{{ auth()->user()->email }}" class="email">{{ auth()->user()->email }}</a></p>
            </div>
        @else
            <p>No hay usuario autenticado</p>
        @endif
    </div>
</div>
