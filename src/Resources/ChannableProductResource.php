<?php

namespace Dashed\DashedEcommerceChannable\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChannableProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $categories = [];

        foreach ($this->productCategories as $category) {
            $categories[] = $category->name;
        }

        $array = [
            'id' => $this->id,
            'product_group_id' => $this->productGroup->id,
            'title' => $this->name,
            'link' => url($this->getUrl()),
            'price' => $this->currentPrice,
            'sale_price' => $this->discountPrice,
            'availability' => $this->directSellableStock() ? true : false,
            'stock' => $this->directSellableStock(),
            'description' => $this->description ? $this->description : $this->productGroup->description,
            'short_description' => $this->short_description ? $this->short_description : $this->productGroup->short_description,
            'ean' => $this->ean,
            'sku' => $this->sku,
            'image_link' => $this->firstImage ? (mediaHelper()->getSingleMedia($this->firstImage, 'original')->url ?? '') : ($this->productGroup->firstImage ? (mediaHelper()->getSingleMedia($this->productGroup->firstImage, 'original')->url ?? '') : null),
            'first_category' => $this->productCategories->first() ? $this->productCategories->first()->name : null,
            'categories' => $categories,
        ];

        $array['images'] = $this->originalImagesToShow;

        $characteristics = $this->allCharacteristics();
        foreach ($this->productGroup->allCharacteristicsWithoutFilters() as $characteristic) {
            if (collect($characteristics)->where('name', $characteristic['name'])->count() > 0) {
                $characteristics[collect($characteristics)->where('name', $characteristic['name'])->keys()[0]]['value'] = $characteristic['value'];
            } else {
                $characteristics[] = $characteristic;
            }
        }

        foreach ($characteristics as $characteristic) {
            if ($characteristic['value'] !== null && $characteristic['value'] !== '') {
                $array[$characteristic['name']] = $characteristic['value'];
            }
        }

        return $array;
    }
}
