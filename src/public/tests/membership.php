Sim — e dá para fazer 100% com HTML + Bootstrap + CSS, de forma que a carteirinha fique bonita na tela e também seja imprimível.

Eu faria /membership como uma página que mostra uma carteirinha centralizada, com uma versão otimizada para impressão. Por exemplo:

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Library Membership Card</title>

  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >

  <style>
    body {
      background: #f1f3f5;
    }

    .membership-card {
      width: 540px;
      max-width: 100%;
      aspect-ratio: 1.586 / 1;
      border-radius: 20px;
      overflow: hidden;
      position: relative;
      color: white;
      background:
        linear-gradient(135deg, #0d6efd, #084298);
      box-shadow: 0 15px 40px rgba(0, 0, 0, .2);
    }

    .membership-card::after {
      content: "";
      position: absolute;
      width: 300px;
      height: 300px;
      border-radius: 50%;
      background: rgba(255,255,255,.08);
      right: -100px;
      bottom: -130px;
    }

    .library-logo {
      width: 45px;
      height: 45px;
      border-radius: 12px;
      background: rgba(255,255,255,.15);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .member-photo {
      width: 100px;
      height: 100px;
      border-radius: 14px;
      object-fit: cover;
      border: 3px solid rgba(255,255,255,.7);
    }

    .member-number {
      letter-spacing: 3px;
      font-family: monospace;
    }

    @media print {

      @page {
        size: auto;
        margin: 10mm;
      }

      body {
        background: white;
      }

      .no-print {
        display: none !important;
      }

      .membership-card {
        box-shadow: none;
        print-color-adjust: exact;
        -webkit-print-color-adjust: exact;
      }
    }
  </style>
</head>

<body>

  <div class="container py-5">

    <!-- Print button -->
    <div class="text-center mb-4 no-print">
      <button
        onclick="window.print()"
        class="btn btn-primary"
      >
        <i class="bi bi-printer me-2"></i>
        Print membership card
      </button>
    </div>


    <!-- Card -->
    <div class="d-flex justify-content-center">

      <div class="membership-card p-4">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center">

          <div class="d-flex align-items-center gap-3">

            <div class="library-logo">
              <i class="bi bi-book fs-4"></i>
            </div>

            <div>
              <div class="fw-bold">
                LibrarySystem
              </div>

              <small class="opacity-75">
                Public Library
              </small>
            </div>

          </div>

          <small class="text-uppercase opacity-75">
            Membership
          </small>

        </div>


        <!-- Member -->
        <div class="d-flex align-items-center gap-4 mt-4">

          <img
            src="/images/member.jpg"
            class="member-photo"
            alt="Member"
          >

          <div>
            <small class="opacity-75">
              MEMBER
            </small>

            <h3 class="fw-bold mb-1">
              John Smith
            </h3>

            <small class="opacity-75">
              Member since 2026
            </small>
          </div>

        </div>


        <!-- Footer -->
        <div class="position-absolute bottom-0 start-0 end-0 p-4">

          <div class="d-flex justify-content-between align-items-end">

            <div>
              <small class="opacity-75 d-block">
                MEMBER ID
              </small>

              <strong class="member-number">
                LIB-2026-001284
              </strong>
            </div>

            <div class="text-end">
              <small class="opacity-75 d-block">
                VALID UNTIL
              </small>

              <strong>
                12 / 2027
              </strong>
            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

</body>
</html>

E o mais interessante

Você pode gerar essa página dinamicamente:

/membership

ou:

/membership/1284

E preencher:

John Smith
LIB-2026-001284
12 / 2027

com os dados do membro.
Para impressão

O navegador já faz o trabalho:

window.print();

E o CSS:

@media print {
    .no-print {
        display: none !important;
    }

    .membership-card {
        box-shadow: none;
        print-color-adjust: exact;
        -webkit-print-color-adjust: exact;
    }
}

faz com que só a carteirinha seja impressa.
Eu iria um passo além

Como é um sistema de biblioteca, você poderia colocar um QR Code na carteirinha:

┌─────────────────────────────────────────────┐
│ 📚 LibrarySystem                  MEMBERSHIP │
│                                             │
│   [ FOTO ]    JOHN SMITH                    │
│               Member since 2026             │
│                                             │
│   ID: LIB-2026-001284              [ QR ]   │
│                                  ████████   │
└─────────────────────────────────────────────┘

O QR poderia apontar para:

https://seusistema.com/membership/LIB-2026-001284

Assim, quando alguém escanear a carteirinha, você pode mostrar uma página pública dizendo algo como:

    John Smith
    ✓ Active member
    Library: Central Library
    Member since: 2026

Isso transforma a carteirinha de um simples HTML imprimível em uma credencial verificável.

E sim, dá para fazer a versão impressa em formato de cartão de crédito (CR80) também, se você quiser que a pessoa possa imprimir em papel/cartão e recortar.