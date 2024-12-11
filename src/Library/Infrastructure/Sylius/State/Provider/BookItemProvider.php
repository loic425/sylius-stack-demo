<?php

declare(strict_types=1);

namespace App\Library\Infrastructure\Sylius\State\Provider;

use App\Library\UI\Admin\Resource\BookResource;
use Sylius\Resource\Context\Context;
use Sylius\Resource\Context\Option\RequestOption;
use Sylius\Resource\Metadata\Operation;
use Sylius\Resource\State\ProviderInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Webmozart\Assert\Assert;

final readonly class BookItemProvider implements ProviderInterface
{
    public function __construct(
        private HttpClientInterface $bookClient,
    ) {
    }

    public function provide(Operation $operation, Context $context): BookResource|null
    {
        $request = $context->get(RequestOption::class)?->request();
        Assert::notNull($request);

        $id = $request->attributes->getInt('id');

        return $this->findBook($id);
    }

    public function findBook(int $id): BookResource|null
    {
        $response = $this->bookClient->request(method: 'GET', url: 'en/books');

        foreach ($response->toArray() as $row) {
            if ($row['number'] === $id) {
                return new BookResource(...$row);
            }
        }

        return null;
    }
}
