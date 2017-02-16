<?php 

namespace Controllers;

use Config\Config;
use Entity\Usuarios;
use Entity\Peliculas;
use Entity\Videos;
use Entity\Series;
use Entity\Capitulos;
use Entity\Etiquetas;

/**
* Controlador Default
*/
class DefaultController extends Config {

	public function index() {
		if (isset($_POST['id'])) {
			$this->render('homepage/detalles.twig', array( 'movie' => Peliculas::view($_POST['id']), 'detalles' => Videos::viewPeliculas($_POST['id']), 'movies' => Peliculas::listAll()));
		}elseif(isset($_POST['search'])){
			$search = Peliculas::search($_POST['search']);
			$this->render('homepage/buscar.twig', array( 'movies' => $search));	
		}else{
			$this->render('homepage/index.twig');
		}
	}

	public function homepage() {
        if (isset($_POST['id'])) {
            $this->render('homepage/capitulos.twig', array( 'capitulos' => Capitulos::listCapitulos($_POST['id']), 'serie' => Series::view($_POST['id'])));
        }elseif(isset($_POST['idvideo'])) {
            $this->render('homepage/rep_capitulo.twig', array('repcapitulo' => Videos::viewCapitulo($_POST['idvideo']), 'capitulo' => Capitulos::view($_POST['idvideo'])));
        }elseif (isset($_POST['idmovie'])) {
			$this->render('homepage/rep_movie.twig', array('repmovie' => Videos::viewPelicula($_POST['idmovie']), 'num' => Videos::numReproducion($_POST['idmovie'])));
		}elseif (isset($_POST['idtrailer'])) {
			$this->render('homepage/rep_trailer.twig', array('reptrailer' => Peliculas::view($_POST['idtrailer'])));
        }else{
            $this->render('homepage/homepage.twig',array('movies' => Peliculas::listAll(), 'series' => Series::listAll(), 'sliders' => Peliculas::listSlider(), 'generos' => Etiquetas::listAll()));
        }
    }

	public function login() {

		if (isset($_POST['login'])) {
			$authorization = Usuarios::verifyUser($_POST['user_name'], $_POST['password']);
		}else{
			$authorization['perfil'] = 'none';
		}

		switch ($authorization['perfil']) {
			case 'ADMIN':
				$_SESSION['ADMIN'] = true;
				$_SESSION['ID'] = $authorization['idusuario'];
				header('Location: /backend/users');
				break;
			
			case false:
				$array = array('error' => true);
				break;

			case 'none':
				$array = array();
				break;
		}

		$this->render('homepage/login.twig', $array);
	}

	public function error404() {
		$this->render('errors/error-404.twig');
	}
}