<?php

use Phalcon\Session\Adapter\Files as Session;

class LoginController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
        $session = $this->di->get('session');
        if ($this->session->has("logged_in")) {
            if ($this->session->get("logged_in") == true) {
                header("location: ../menu");
            }
        }

        if ($this->session->has("login_fill") and $this->session->has("password_fill")) {
            $this->view->user_name = $this->session->get("login_fill");
            $this->view->password  = $this->session->get("password_fill");
            $this->view->remember  = "checked";
        } else {
            $this->view->user_name = "";
            $this->view->password  = "";
            $this->view->remember  = "";
        }

        if (!$this->request->isGet()) {
            $post = $this->request->getPost();

            if (isset($post['rememberMe'])) {
                $session->set("login_fill", $post['username']);
                $session->set("password_fill", $post['password']);
                $this->view->user_name = $this->session->get("login_fill");
                $this->view->password  = $this->session->get("password_fill");
                $this->view->remember  = "checked";
            } else {
                $this->view->remember = "";
            }

            $user = Usuarios::login($post['username'], $post['password']);

            if ($user) {
                //criar sessao para usuario e redirecionar
                $session->set("logged_in", "true");

                //header("location: /menu");

            } else {
                $this->view->error = '<span class="error-txt">Credenciais inválidas</span>';
            }
        }

    }

}
