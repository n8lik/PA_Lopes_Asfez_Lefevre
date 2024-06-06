<?php require 'includes/header.php';
?>
<link rel="stylesheet" href="/css/index.css">


<div id="carouselIndexIndicators" class="carousel slide" data-bs-ride="carousel" style="margin-bottom: 4em;">
	<div class="carousel-indicators">
		<button type="button" data-bs-target="#carouselIndexIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
		<button type="button" data-bs-target="#carouselIndexIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
		<button type="button" data-bs-target="#carouselIndexIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
		<button type="button" data-bs-target="#carouselIndexIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
		<button type="button" data-bs-target="#carouselIndexIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>

	</div>
	<div class="carousel-inner">
		<div class="carousel-item active" data-bs-interval="5000">
			<img src="/assets/img/indexCarroussel/indexCarroussel1.jpg" class="d-block w-100" alt="Beach">
		</div>
		<div class="carousel-item" data-bs-interval="5000">
			<img src="/assets/img/indexCarroussel/indexCarroussel2.jpg" class="d-block w-100" alt="Cove">
		</div>
		<div class="carousel-item" data-bs-interval="5000">
			<img src="/assets/img/indexCarroussel/indexCarroussel3.jpg" class="d-block w-100" alt="Frozen mountain">
		</div>
		<div class="carousel-item" data-bs-interval="5000">
			<img src="/assets/img/indexCarroussel/indexCarroussel4.jpg" class="d-block w-100" alt="River">
		</div>
		<div class="carousel-item" data-bs-interval="5000">
			<img src="/assets/img/indexCarroussel/indexCarroussel5.jpg" class="d-block w-100" alt="Mountain">
		</div>
	</div>
	<div class="carousel-caption d-none d-md-block">
		<form class="d-flex" action="catalog?choice=housing" method="POST">
			<input name="destination" id="destinationInput" class="form-control me-2" type="text" placeholder="Destination" aria-label="Search" required>
			<input name="arrivalDate" class="form-control me-2" type="date" placeholder="Date d'arrivée" aria-label="Search">
			<input name="departureDate" class="form-control me-2" type="date" placeholder="Date de départ" aria-label="Search">
			<input name="travelers" class="form-control me-2" type="number" placeholder="Nombre de voyageurs" aria-label="Search" min="1" max="10">
			<button class="btn btn-outline-light" type="submit">Rechercher</button>
		</form>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-12">
			<h2>Vos destinations favorites</h2>
			<p>Retrouvez ici les destinations les plus populaires en France</p>
		</div>
	</div>
	<div class="row" style="margin-bottom: 1em;">
		<div class="col-12 col-md-6">
			<div class="card">
				<img src="/assets/img/indexDestination/paris.jpg" class="card-img-top" alt="Paris" >
				<div class="card-body">
					<h5 class="card-title">Paris</h5>
					<p class="card-text"> Visitez la ville lumière et ses monuments historiques.</p>
					<form action="catalog?choice=housing" method="POST">
						<input type="hidden" name="destination" value="Paris">
						<button type="submit" class="btn btn-primary">Voir plus</button>
					</form>

				</div>
			</div>
		</div>
		<div class="col-12 col-md-6">
			<div class="card">
				<img src="/assets/img/indexDestination/marseille.jpg" class="card-img-top" alt="Marseille">
				<div class="card-body">
					<h5 class="card-title">Marseille</h5>
					<p class="card-text">Découvrez la cité phocéenne et ses calanques.</p>
					<form action="catalog?choice=housing" method="POST">
						<input type="hidden" name="destination" value="Marseille">
						<button type="submit" class="btn btn-primary">Voir plus</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 4em;">
		<div class="col-12 col-md-4">
			<div class="card">
				<img src="/assets/img/indexDestination/annecy.jpg" class="card-img-top" alt="Annecy">
				<div class="card-body">
					<h5 class="card-title">Annecy</h5>
					<p class="card-text">Profitez du lac d'Annecy et de ses montagnes.</p>
					<form action="catalog?choice=housing" method="POST">
						<input type="hidden" name="destination" value="Annecy">
						<button type="submit" class="btn btn-primary">Voir plus</button>
					</form>

				</div>
			</div>
		</div>
		<div class="col-12 col-md-4">
			<div class="card">
				<img src="/assets/img/indexDestination/bordeaux.jpg" class="card-img-top" alt="Bordeaux">
				<div class="card-body">
					<h5 class="card-title">Bordeaux</h5>
					<p class="card-text">Dégustez les vins de Bordeaux et visitez la ville.</p>
					<form action="catalog?choice=housing" method="POST">
						<input type="hidden" name="destination" value="Bordeaux">
						<button type="submit" class="btn btn-primary">Voir plus</button>
					</form>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-4">
			<div class="card">
				<img src="/assets/img/indexDestination/alsace.jpg" class="card-img-top" alt="Strasbourg">
				<div class="card-body">
					<h5 class="card-title">Strasbourg</h5>
					<p class="card-text">Découvrez les villages alsaciens et leur charme.</p>
					<form action="catalog?choice=housing" method="POST">
						<input type="hidden" name="destination" value="Strasbourg">
						<button type="submit" class="btn btn-primary">Voir plus</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-12">
			<h2>Les activités les plus populaires</h2>
			<p>Retrouvez ici les activités les plus populaires en France</p>
		</div>
	</div>
</div>
<div id="carouselActivitiesIndicators" class="carousel slide" data-bs-ride="carousel" style="margin-bottom: 4em;">
	<div class="carousel-indicators">
		<button type="button" data-bs-target="#carouselActivitiesIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
		<button type="button" data-bs-target="#carouselActivitiesIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
		<button type="button" data-bs-target="#carouselActivitiesIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
		<button type="button" data-bs-target="#carouselActivitiesIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
	</div>
	<div class="carousel-inner">
		<div class="carousel-item active" data-bs-interval="5000">
			<img src="/assets/img/activities/activity1.jpg" class="d-block w-100" alt="Activity 1">
		</div>
		<div class="carousel-item" data-bs-interval="5000">
			<img src="/assets/img/activities/activity2.jpg" class="d-block w-100" alt="Activity 2">
		</div>
		<div class="carousel-item" data-bs-interval="5000">
			<img src="/assets/img/activities/activity3.jpg" class="d-block w-100" alt="Activity 3">
		</div>
		<div class="carousel-item" data-bs-interval="5000">
			<img src="/assets/img/activities/activity4.jpg" class="d-block w-100" alt="Activity 4">
		</div>
	</div>
	<div class="carousel-caption d-none d-md-block">
		<form class="d-flex">
			<input class="form-control me-2" type="text" placeholder="Activité" aria-label="Search" required>
			<input class="form-control me-2" type="date" placeholder="Date" aria-label="Search" required>
			<button class="btn btn-outline-light" type="submit">Rechercher</button>
		</form>
	</div>
</div>



<?php include 'includes/footer.php'; ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBfTvwEttd84Lx7xTxVqNk85d6z3CaDYrE&libraries=places&callback=initAutocomplete" async defer></script>
<script>
    function initAutocomplete() {
        var input = document.getElementById('destinationInput');
        var options = {
            //Limites aux villes
            types: ['(cities)'],
        };
        new google.maps.places.Autocomplete(input, options);
    }
</script>