<?php

namespace Qubiqx\QcommerceEcommerceChannable\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Qubiqx\QcommerceEcommerceChannable\Models\ChannableOrder;
use Qubiqx\QcommerceEcommerceEboekhouden\Models\EboekhoudenOrder;

class ChannableOrderStats extends StatsOverviewWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Aantal bestellingen vanuit Channable', ChannableOrder::count()),
        ];
    }
}
