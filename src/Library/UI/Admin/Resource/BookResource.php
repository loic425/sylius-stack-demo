<?php

declare(strict_types=1);

namespace App\Library\UI\Admin\Resource;

use App\Library\Infrastructure\Sylius\State\Provider\BookItemProvider;
use App\Library\UI\Admin\Grid\BookGrid;
use Sylius\Resource\Metadata\AsResource;
use Sylius\Resource\Metadata\Index;
use Sylius\Resource\Metadata\Show;
use Sylius\Resource\Model\ResourceInterface;

#[AsResource(
    section: 'admin',
    templatesDir: '@SyliusAdminUi/crud',
    routePrefix: '/admin/library',
    driver: false,
    operations: [
        new Index(grid: BookGrid::class),
        new Show(provider: BookItemProvider::class),
    ],
)]
class BookResource implements ResourceInterface
{
    public function __construct(
        public int $number,
        public string $title,
        public string $originalTitle,
        public string $releaseDate,
        public string $description,
        public int $pages,
        public string $cover,
        public int $index,
    ) {
    }

    public function getId(): int
    {
        return $this->number;
    }
}
