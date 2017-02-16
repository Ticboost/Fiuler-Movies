<?php 

namespace Controllers;

use Config\Config;
use Entity\Usuarios;
use Entity\Peliculas;
use Entity\Videos;

/**
* Controlador Backend
*/
class BackendController extends Config {

	public function __construct()
	{
		if (empty($_SESSION['ADMIN'])) {
			header('Location: /login');
		}
	}

	public function users($error=false) {
		$users = new Usuarios();
		$this->render('backend/users.twig', array('users' => $users->listAll(), 'error' => $error));
	}

	public function newUser() {

		if(isset($_POST["newUser"])){

			$user = new Usuarios();
			if (!empty($_POST['id'])) {
				$user->setId($_POST['id']);
			}
			$user->setEmail($_POST['email']);
			$user->setContrasena($_POST['password']);
			$user->setPerfil($_POST['perfil']);
			$user->save();

			$this->users();
		}else{
			$this->render('backend/formUser.twig');
		}
	}

	public function editUser($id=null) {
		if (!empty($id)) {
			$user = new Usuarios();
			$this->render('backend/formUser.twig', array('user' =>$user->view($id), 'id' => $id));
		} else {
			$this->users(true);
		}	
	}

	public function deleteUser($id=null) {
		if (!empty($id)) {
			$user = new Usuarios();
			$user->delete($id);
			$this->users();
		} else {
			$this->users(true);
		}	
	}

	public function movies($error=false) {
		$movies = new Peliculas();
		$this->render('backend/movies.twig', array('movies' => $movies->listAll(), 'error' => $error));
	}

	public function viewMovieDetalles($id) {
		$this->render('backend/movieDetalles.twig', array('detalles' => Videos::viewPeliculas($id)));
	}

	public function newMovie() {
		if(isset($_POST["newMovie"])){
			$movie = new Peliculas();
			$video = new Videos();

			if (!empty($_POST['id'])) {
				$movie->setId($_POST['id']);
			}

			$movie->setNombre($_POST['nombre']);
			$movie->setSinopsis($_POST['sinopsis']);
			$movie->setTrailer($_POST['trailer']);
			$movie->fileImagen($_FILES['imagen']);
			$movie->filePortada($_FILES['portada']);
			$movie->setProd_ano($_POST['prod_ano']);

			$movie->save();

			if (!empty($_POST['url'])) {
				$registro_movie = Peliculas::search($_POST['nombre']);

				if (!empty($_POST['idvideo'])) {
					$video->setId($_POST['idvideo']);
				}

				$video->setUrl($_POST['url']);
				$video->setCalidad($_POST['calidad']);
				$video->setEstado($_POST['estado']);
				$video->setFecha($_POST['fecha']);
				$video->setIdioma($_POST['idioma']);
				$video->setIdPelicula($registro_movie[0]['idpelicula']);
				$video->setIdUsuario($_SESSION['ID']);

				$video->savePelicula();
			}

			$this->movies();
		}else{
			$this->render('backend/formMovie.twig', array('new' => true));
		}
	}

	public function editMovie($id=null) {
		if (!empty($id)) {
			$this->render('backend/formMovie.twig', array('movie' =>Peliculas::view($id), 'id' => $id));
		} else {
			$this->movies(true);
		}	
	}

	public function deleteMovie($id=null) {
		if (!empty($id)) {
			Peliculas::delete($id);
			$this->movies();
		} else {
			$this->movies(true);
		}	
	}

	public function newUrl($id=null) {

		$video = new Videos();

		if(isset($_POST["newUrl"])){

			if (!empty($_POST['idpelicula'])) {
				$video->setId($_POST['idpelicula']);
			}

			if (!empty($_POST['url'])) {

				$video->setUrl($_POST['url']);
				$video->setCalidad($_POST['calidad']);
				$video->setEstado($_POST['estado']);
				$video->setFecha($_POST['fecha']);
				$video->setIdioma($_POST['idioma']);
				$video->setIdPelicula($_POST['idpelicula']);
				$video->setIdUsuario($_SESSION['ID']);
				$video->savePelicula();
			}
			$this->movies();
			}else{
			$this->render('backend/formDetalles.twig', array('detalles' =>Videos::viewPelicula($id), 'id' => $id));
		}
	}

	public function editUrl($idvideo=null){
		if (!empty($idvideo)) {
			$this->render('backend/formMovieDetalles.twig', array('detalles' =>Videos::viewVideo($idvideo), 'id' => $idvideo));
		} else {
			$this->movies(true);
		}	
	}

	public function deleteUrl($idvideo=null) {
		if (!empty($idvideo)) {
			Videos::deletePelicula($idvideo);
			$this->movies();
		} else {
			$this->movies(true);
		}	
	}

	public function close(){
		session_destroy();
		clearstatcache();
		header('Location: /login');
	}

}