<?php

namespace Router;

class RouteRequest
{

    private $routes = [];
    private $method;
    private $path;
    private $params;

    public function __construct($method, $path)
    {
        $this->method = $method;
        $this->path = $path;
    }


    public function get(string $route,  $action)
    {
        $this->add('GET', $route, $action);
    }

    public function post(string $route,  $action)
    {
        $this->add('POST', $route, $action);
    }

   
    public function add(string $method, string $route,  $action)
    {
        $this->routes[$method][$route] = $action;
    }

    public function getParams()
    {
        return $this->params;
    }

    
    public function handler()
    {
      
		if (empty($this->routes[$this->method])) {
            return false;
        }

        if (isset($this->routes[$this->method][$this->path])) {
            return $this->routes[$this->method][$this->path];
        }

        // Pego TODAS as rotas dentro do método http informado
        foreach ($this->routes[$this->method] as $route => $action) {
            // e testo cada uma
            $result = $this->checkUrl($route, $this->path);
            // se encontrar um resultado
            if ($result >= 1) {
                // retorno a $action (assim como no if anterior)
                return $action;
            }
        }

        // se não achar nada, retorno false
        return false;
    }

	// este método recebe dois parâmetros, $route e $path
    // $route é a rota registrada que vamos testar
    // $path e a url amigável que quero procurar
    private function checkUrl(string $route, $path)
    {
        preg_match_all('/\{([^\}]*)\}/', $route, $variables);

        $regex = str_replace('/', '\/', $route);

        foreach ($variables[0] as $k => $variable) {
            $replacement = '([a-zA-Z0-9\-\_\ ]+)';
            $regex = str_replace($variable, $replacement, $regex);
        }

        $regex = preg_replace('/{([a-zA-Z]+)}/', '([a-zA-Z0-9+])', $regex);

        // adicionei a variável $params para "guardar" os parâmetros variáveis
        // que a regex encontrar
        $result = preg_match('/^' . $regex . '$/', $path, $params);
        // guardo na variável params da classe
        $this->params = $params;

        return $result;

}
}