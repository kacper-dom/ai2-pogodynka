<?php
namespace App\Controller;
use App\Repository\MeasurementRepository;
use App\Repository\LocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
final class WeatherController extends AbstractController
{
    #[Route('/weather/{city}/{country}', name: 'app_weather')]
    public function city(
        string $city,
        string $country,
        MeasurementRepository $repository,
        LocationRepository $locationRepository,
    ): Response
    {
        $location = $locationRepository->findByCityAndCountry($city, $country);
        $measurements = $repository->findByLocation($location);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $measurements,
        ]);
    }
}
