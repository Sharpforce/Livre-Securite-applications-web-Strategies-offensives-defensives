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

  if(isset($_GET['redirect']) && !empty($_GET['redirect'])) {
    header("Location: " . $_GET['redirect'], true, 302);
    exit();
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
                    <h1>Accédez à vos réseaux sociaux</h1>
                    <form method="GET" action="./home.php">
                      <select class="form-select form-select-sm" name="redirect" onchange="this.form.submit()">
                        <option selected disabled>Choix</option>
                        <option value="https://facebook.com/">Facebook</option>
                        <option value="https://instagram.com/">Instagram</option>
                        <option value="https://twitter.com/">Twitter</option>
                      </select>
                    </form>
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
    <script src="../../../js/bootstrap.min.js"></script>
  </body>
</html>