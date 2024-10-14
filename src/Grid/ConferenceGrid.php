<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Grid;

use App\Entity\Conference;
use Sylius\Bundle\GridBundle\Builder\Action\Action;
use Sylius\Bundle\GridBundle\Builder\Action\CreateAction;
use Sylius\Bundle\GridBundle\Builder\Action\DeleteAction;
use Sylius\Bundle\GridBundle\Builder\Action\UpdateAction;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\BulkActionGroup;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\ItemActionGroup;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\MainActionGroup;
use Sylius\Bundle\GridBundle\Builder\Field\DateTimeField;
use Sylius\Bundle\GridBundle\Builder\Field\StringField;
use Sylius\Bundle\GridBundle\Builder\Filter\BooleanFilter;
use Sylius\Bundle\GridBundle\Builder\Filter\DateFilter;
use Sylius\Bundle\GridBundle\Builder\Filter\ExistsFilter;
use Sylius\Bundle\GridBundle\Builder\GridBuilderInterface;
use Sylius\Bundle\GridBundle\Grid\AbstractGrid;
use Sylius\Bundle\GridBundle\Grid\ResourceAwareGridInterface;

final class ConferenceGrid extends AbstractGrid implements ResourceAwareGridInterface
{
    public static function getName(): string
    {
        return 'app_admin_conference';
    }

    public function buildGrid(GridBuilderInterface $gridBuilder): void
    {
        $gridBuilder
            ->addOrderBy('startsAt', 'desc')
            ->addFilter(
                BooleanFilter::create('pastEvent')
                    ->setLabel('app.ui.past_event'),
            )
            ->addFilter(
                DateFilter::create('startsAt')
                    ->setLabel('app.ui.starts_at'),
            )
            ->addFilter(
                ExistsFilter::create('archival', 'archivedAt')
                    ->setDefaultValue(false)
                    ->setLabel('app.ui.archival'),
            )
            ->addField(
                StringField::create('name')
                    ->setLabel('app.ui.name')
                    ->setSortable(true),
            )
            ->addField(
                DateTimeField::create('startsAt')
                    ->setLabel('app.ui.starts_at')
                    ->setSortable(true),
            )
            ->addField(
                DateTimeField::create('endsAt')
                    ->setLabel('app.ui.ends_at')
                    ->setSortable(true),
            )
            ->addActionGroup(
                MainActionGroup::create(
                    CreateAction::create(),
                ),
            )
            ->addActionGroup(
                ItemActionGroup::create(
                    Action::create('show_talks', 'show')
                        ->setIcon('list_letters')
                        ->setLabel('app.ui.show_talks')
                        ->setOptions([
                            'link' => [
                                'route' => 'app_admin_talk_index',
                                'parameters' => [
                                    'criteria' => [
                                        'conference' => 'resource.id',
                                    ],
                                ],
                            ],
                        ]),
                    UpdateAction::create(),
                    DeleteAction::create(),
                ),
            )
            ->addActionGroup(
                BulkActionGroup::create(
                    DeleteAction::create(),
                ),
            )
        ;
    }

    public function getResourceClass(): string
    {
        return Conference::class;
    }
}
