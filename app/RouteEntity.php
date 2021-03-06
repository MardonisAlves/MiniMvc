<?php
namespace App\Controllers;

class RouteEntity
{

      private $action;
      private $afterMiddleware = [];
      private $beforeMiddleware = [];
  
      // a ação principal
      public function __construct($action)
      {
          $this->action = $action;
      }
  
      // adicionar middlewares antes da ação principal
      public function before($middleware)
      {
          $this->beforeMiddleware[] = $middleware;
          return $this;
      }
  
      // adicionar middlewares depois da ação principal
      public function after($middleware)
      {
          $this->afterMiddleware[] = $middleware;
          return $this;
      }
  
      // retorna todas as ações a serem executadas
      public function getData()
      {
          return [
              'action' => $this->action,
              'after' => $this->afterMiddleware,
              'before' => $this->beforeMiddleware,
          ];
      }

}
