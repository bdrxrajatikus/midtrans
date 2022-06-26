<html>
  <head>
  <link rel="preconnect" href="https://fonts.gstatic.com"> 
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background-color: white;
    }

    button, button::after {
      width: 380px;
      height: 86px;
      font-size: 36px;
      font-family: 'Bebas Neue';
      background: #0307fc ;
      border: 0;
      color: #fff;
      letter-spacing: 3px;
      line-height: 88px;
      box-shadow: 6px 0px 0px #00E6F6;
      outline: transparent;
      position: relative;
    }

    button::after {
      display: block;
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(45deg, transparent 3%, #00E6F6 3%, #00E6F6 5%, #FF013C 5%);
      text-shadow: -3px -3px 0px #F8F005, 3px 3px 0px #00E6F6;
      clip-path: var(--slice-0);
    }

    
    </style>
  </head>
  <body>
    
  <form action="/payment" method="GET">
    <button>START & PAY</button>
  </form>
  @if(session('alert-failed'))
  <script>alert("{{session('alert-failed')}}")</script>
  @endif
  </body>
</html>