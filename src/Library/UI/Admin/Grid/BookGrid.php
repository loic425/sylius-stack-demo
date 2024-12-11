<?php

declare(strict_types=1);

namespace App\Library\UI\Admin\Grid;

use App\Library\Infrastructure\Sylius\Grid\Provider\BookGridProvider;
use App\Library\UI\Admin\Resource\BookResource;
use Sylius\Bundle\GridBundle\Builder\Action\ShowAction;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\ItemActionGroup;
use Sylius\Bundle\GridBundle\Builder\Field\StringField;
use Sylius\Bundle\GridBundle\Builder\Field\TwigField;
use Sylius\Bundle\GridBundle\Builder\GridBuilderInterface;
use Sylius\Bundle\GridBundle\Grid\AbstractGrid;
use Sylius\Bundle\GridBundle\Grid\ResourceAwareGridInterface;

final class BookGrid extends AbstractGrid implements ResourceAwareGridInterface
{
    #[\Override]
    public static function getName(): string
    {
        return 'app_admin_book';
    }

    #[\Override]
    public function buildGrid(GridBuilderInterface $gridBuilder): void
    {
        $gridBuilder
            ->setProvider(BookGridProvider::class)
            ->addField(
                TwigField::create('cover', 'library/book/grid/field/cover.html.twig')
            )
            ->addField(
                StringField::create('title')
            )
            ->addField(
                StringField::create('pages')
            )
            ->addField(
                StringField::create('releaseDate')
            )
            ->addActionGroup(
                ItemActionGroup::create(
                    ShowAction::create(),
                )
            )
        ;
    }

    #[\Override]
    public function getResourceClass(): string
    {
        return BookResource::class;
    }
}
