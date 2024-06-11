<?php
  define('WEP_APP_PAGE_TO_ROOT', './../../../' );
  include_once __DIR__ . '/config/const.php';
  include_once __DIR__ . '/config/database.php';
  session_start();

  if(isset($_POST['username']) && empty($_POST['username'])) {
    header("Location: index.php?error=" . urlencode('Le nom d\'utilisateur doit être renseigné.'), true, 302);
    exit();
  }
  if(isset($_POST['password']) && empty($_POST['password'])) {
    header("Location: index.php?error=" . urlencode('Le mot de passe doit être renseigné.'), true, 302);
    exit();
  }

  if(isset($_POST['username']) || isset($_POST['password'])) {
    if(isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password'])) {
      try {
        $cnx = new PDO('mysql:host='. $_bdd['server'] . ';dbname=' . $_bdd['database'], $_bdd['user'], $_bdd['password']);
        $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $cnx->prepare("SELECT id, username, firstname, lastname, password, role FROM users WHERE username = ?");
        $stmt->bindParam(1, $_POST["username"], PDO::PARAM_STR);
        $stmt->execute(); 

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!password_verify($_POST['password'], $user['password'])) {
          header("Location: index.php?error=" . urlencode('Le nom d\'utilisateur ou le mot de passe est incorrect.'), true, 302);
          exit();
        }

        $_SESSION['exercice'] = EXERCICE;
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['firstname'] = $user['firstname'];
        $_SESSION['lastname'] = $user['lastname'];
        $_SESSION['role'] = $user['role'];
      }
      catch(Exception $e) {
        header("Location: index.php?error=" . urlencode(("Une erreur technique s'est produite.")), true, 302);
        exit();
      }          
    }
  }

  if(!isset($_SESSION['exercice']) || $_SESSION['exercice'] !== EXERCICE || !isset($_SESSION['username'])) {
    header("Location: index.php?error=Vous devez vous authentifier avant de poursuivre.", true, 302);
    exit();
  }

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_SERVER["CONTENT_TYPE"] === "application/xml") {
      $xmlUserContent = file_get_contents("php://input");
      $dom = new DOMDocument();      
      $result = $dom->loadXML($xmlUserContent, LIBXML_NOENT);

      $movie = simplexml_import_dom($dom);
      $name = $movie->name;

      switch($name) {
        case 'hackers':
          $title = "Hackers (1995)";
          $summary = "Un film sur un groupe de jeunes hackers.";
          echo $title . " : " . $summary;
          break;
        case 'takedown':
          $title = "Takedown (2000)";
          $summary = "Ce film relate la traque et l'arrestation du célèbre hacker Kevin Mitnick, mettant en vedette Skeet Ulrich dans le rôle de Mitnick et Russell Wong dans le rôle de Tsutomu Shimomura.";
          echo $title . " : " . $summary;
          break;
        case 'the_matrix':
          $title = "The Matrix (1999)";
          $summary = "Bien que principalement un film de science-fiction, il aborde des concepts liés à la réalité virtuelle et à la sécurité informatique.";
          echo $title . " : " . $summary;
          break;
        case 'wargames':
          $title = "WarGames (1983)";
          $summary = "Un classique sur un adolescent qui accidentellement pirate le système de contrôle des armes nucléaires.";
          echo $title . " : " . $summary;
          break;
        case 'black_mirror':
          $title = "Black Mirror (2011)";
          $summary = "Bien que chaque épisode soit indépendant, certains explorent des thèmes liés à la cybersécurité et à la technologie.";
          echo $title . " : " . $summary;
          break;
        case 'mr_robot':
          $title = "Mr. Robot (2015)";
          $summary = "Une série qui suit un jeune programmeur et hacktiviste.";
          echo $title . " : " . $summary;
          break;
        case 'csi_cyber':
          $title = "CSI: Cyber (2015)";
          $summary = "Une série policière axée sur la cybercriminalité.";
          echo $title . " : " . $summary;
          break;
        default:
          echo $name . " n'est pas un film ou une série valide";
          break;
      }
    
      exit();   
    }
  }
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars(TITLE, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401); ?></title>
    <link href="../../../styles/bootstrap.min.css" rel="stylesheet">
    <link href="../../../styles/platform_styles.css" rel="stylesheet">
    <link href="../../../styles/exercice_styles.css" rel="stylesheet">
  </head>
  <body>
    <?php
      include WEP_APP_PAGE_TO_ROOT . "inc/navbar.inc.php";
    ?>
    <div class="container-fluid ps-0">
      <div class="row">
        <div class="col-2">
          <div>
            <?php
              include WEP_APP_PAGE_TO_ROOT . "inc/nav.inc.php";
            ?>
          </div>
        </div>
        <div class="col">
          <div class="bg-light m-4 border exercice">
            <?php
              include_once __DIR__ . '/inc/navbar.inc.php';
            ?>
            <div class="row view">
              <div class="d-flex align-items-center">
                <div class="col-2">
                </div>
                <div class="col">
                  <div class="bg-white p-3 border border-secondary rounded">
                    <h1>Bienvenue sur Notre Plateforme!</h1>
                    <h2>Félicitations, <?php echo htmlspecialchars($_SESSION['firstname'], ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401) . ' ' . htmlspecialchars($_SESSION['lastname'], ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401); ?>!</h2>
                    <p>
                      Nous sommes ravis de vous accueillir sur notre plateforme en ligne. Vous avez désormais accès à toutes les fonctionnalités exclusives réservées aux membres. Explorez nos services, connectez-vous avec d'autres utilisateurs et profitez d'une expérience personnalisée. 
                    </p>
                    <p>
                      Que pouvez-vous faire maintenant?
                    </p>
                    <p>
                      Explorez les détails sur les films et séries centrés sur le thème de la cybersécurité en utilisant le menu ci-dessous :
                    </p>
                    <form>
                      <div class="col-2 mb-3">
                        <select class="form-select form-select-sm" name="movies" onchange="getData()">
                          <option selected disabled> --- Films --- </option>
                          <option value="hackers">Hackers</option>
                          <option value="takedown">Takedown</option>
                          <option value="the_matrix">The Matrix</option>
                          <option value="wargames">WarGames</option>
                          <option disabled> --- Séries --- </option>
                          <option value="black_mirror">Black Mirror</option>
                          <option value="mr_robot">Mr. Robot</option>
                          <option value="csi_cyber">CSI: Cyber</option>
                         </select>
                      </div>
                    </form>
                    <div id="movieData"></div>
                  </div>
                  <div class="error-div">
                    <?php
                      include_once __DIR__ . '/inc/error.php';
                    ?>
                  </div>  
                </div>
                <div class="col-2">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script>
      function getData() {               
        var movie = document.getElementsByName("movies")[0].value;

        if (movie) {
          var xhr = new XMLHttpRequest();

          xhr.onload = function () {
            if (xhr.status == 200) {
              document.getElementById("movieData").textContent = xhr.responseText;
            }
          };

          var data = "<?xml version='1.0'?>" + "<movie><name>" + movie + "</name></movie>";
          xhr.open('POST', './home.php', true);
          xhr.setRequestHeader('Content-Type', 'application/xml');
          xhr.send(data);
        }
      }
    </script>
    <script src="../../../js/bootstrap.min.js"></script>
  </body>
</html>