<?php
namespace App\SAE\Config;
class Conf {
   
  static private array $databaseConfiguration = array(
    // Le nom d'hote est webinfo a l'IUT
    // ou localhost sur votre machine
    // 
    // ou webinfo.iutmontp.univ-montp2.fr
    // pour accéder à webinfo depuis l'extérieur
    'hostname' => '176.131.31.93',
    // A l'IUT, vous avez une BDD nommee comme votre login
    // Sur votre machine, vous devrez creer une BDD
    'database' => 'SAE',
    // À l'IUT, le port de MySQL est particulier : 3316
    // Ailleurs, on utilise le port par défaut : 3306
    'port' => '3306',
    // A l'IUT, c'est votre login
    // Sur votre machine, vous avez surement un compte 'root'
    'login' => 'member',
    // A l'IUT, c'est le même mdp que PhpMyAdmin
    // Sur votre machine personelle, vous avez creez ce mdp a l'installation
    'password' => 'NormanLeBest_66'
  );
   
  static public function getLogin() : string {
    // L'attribut statique $databaseConfiguration 
    // s'obtient avec la syntaxe Conf::$databaseConfiguration 
    // au lieu de $this->databaseConfiguration pour un attribut non statique
    return self::$databaseConfiguration['login'];
  }

  static public function getHostName() : string {
    return self::$databaseConfiguration['hostname'];
  }

  static public function getDataBase() : string {
    return self::$databaseConfiguration['database'];
  }

  static public function getPassword() : string {
    return self::$databaseConfiguration['password'];
  }

  static public function getPort() : string{
      return self::$databaseConfiguration['port'];
  }
    static public function conn() : \mysqli{
        return mysqli_connect(self::getHostName(), self::getLogin(), self::getPassword(), self::getDataBase());
    }
}
?>