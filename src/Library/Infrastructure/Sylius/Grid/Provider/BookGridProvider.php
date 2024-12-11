<?php

declare(strict_types=1);

namespace App\Library\Infrastructure\Sylius\Grid\Provider;

use App\Library\UI\Admin\Resource\BookResource;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Sylius\Component\Grid\Data\DataProviderInterface;
use Sylius\Component\Grid\Definition\Grid;
use Sylius\Component\Grid\Parameters;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class BookGridProvider implements DataProviderInterface
{
    public function __construct(
        private HttpClientInterface $bookClient,
    ) {
    }

    public function getData(Grid $grid, Parameters $parameters): Pagerfanta
    {
        $data = [];

        $response = $this->bookClient->request(method: 'GET', url: 'en/books');
        foreach ($response->toArray() as $row) {
            $data[] = new BookResource(...$row);
        }

        return new Pagerfanta(new ArrayAdapter($data));
    }
}
