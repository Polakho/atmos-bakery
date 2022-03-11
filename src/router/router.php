<?php
namespace App;
class Router {
  /**
   * @var string
   */
  private $viewPath;
  /**
   * @var AltoRouter
   */
  private $router;
  public function __construct(string $viewPath){
    $this->$viewPath = $viewPath;
    $this->router = new \AltoRouter();
  }
  public function get(string $url, string $view, ?string $name = null) {
    $this->router->map('GET', $url, $view, $name);
    return $this;
  }
  public function run() {
    $match = $this->router->match();
    $view = $match['target'];
    require $this->viewPath.$view.'view.php';
    return $this;
  }
}

