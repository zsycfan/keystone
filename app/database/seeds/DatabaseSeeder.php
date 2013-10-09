<?php

class DatabaseSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Eloquent::unguard();

    $homeContentType = new ContentType;
    $homeContentType->name = 'Home';
    $homeContentType->slug = 'home';
    $homeContentType->single = true;
    $homeContentType->rows = 3;
    $homeContentType->save();

    $taglineRegion = new Region;
    $taglineRegion->content_type_id = $homeContentType->id;
    $taglineRegion->name = 'Tagline';
    $taglineRegion->slug = 'tagline';
    $taglineRegion->row = 0;
    $taglineRegion->column_width = 12;
    $taglineRegion->column_offset = 0;
    $taglineRegion->column_order = 0;
    $taglineRegion->save();

    $carouselRegion = new Region;
    $carouselRegion->content_type_id = $homeContentType->id;
    $carouselRegion->name = 'Carousel';
    $carouselRegion->slug = 'carousel';
    $carouselRegion->row = 1;
    $carouselRegion->column_width = 12;
    $carouselRegion->column_offset = 0;
    $carouselRegion->column_order = 0;
    $carouselRegion->save();

    $bodyRegion = new Region;
    $bodyRegion->content_type_id = $homeContentType->id;
    $bodyRegion->name = 'Body';
    $bodyRegion->slug = 'body';
    $bodyRegion->row = 2;
    $bodyRegion->column_width = 8;
    $bodyRegion->column_offset = 0;
    $bodyRegion->column_order = 0;
    $bodyRegion->save();

    $asideRegion = new Region;
    $asideRegion->content_type_id = $homeContentType->id;
    $asideRegion->name = 'Aside';
    $asideRegion->slug = 'aside';
    $asideRegion->row = 2;
    $asideRegion->column_width = 4;
    $asideRegion->column_offset = 0;
    $asideRegion->column_order = 1;
    $asideRegion->save();

    $contentType = new ContentType;
    $contentType->name = 'News';
    $contentType->slug = 'news';
    $contentType->single = false;
    $contentType->save();

    $textElement = new Element;
    $textElement->name = 'Text';
    $textElement->slug = 'text';
    $textElement->save();

    $textElementField = new ElementField;
    $textElementField->element_id = $textElement->id;
    $textElementField->name = 'Content';
    $textElementField->slug = 'content';
    $textElementField->type = 'text';
    $textElementField->save();

    $videoElement = new Element;
    $videoElement->name = 'Video';
    $videoElement->slug = 'video';
    $videoElement->save();

    $elementField = new ElementField;
    $elementField->element_id = $videoElement->id;
    $elementField->name = 'YouTube URL';
    $elementField->slug = 'youtube_url';
    $elementField->type = 'text';
    $elementField->save();

    $boxElement = new Element;
    $boxElement->name = 'Box';
    $boxElement->slug = 'box';
    $boxElement->save();

    $elementField = new ElementField;
    $elementField->element_id = $boxElement->id;
    $elementField->name = 'Heading';
    $elementField->slug = 'heading';
    $elementField->type = 'heading';
    $elementField->save();

    $elementField = new ElementField;
    $elementField->element_id = $boxElement->id;
    $elementField->name = 'Content';
    $elementField->slug = 'content';
    $elementField->type = 'text';
    $elementField->save();

    $elementField = new ElementField;
    $elementField->element_id = $boxElement->id;
    $elementField->name = 'Image';
    $elementField->slug = 'image';
    $elementField->type = 'image';
    $elementField->save();

    $content = new Content;
    $content->content_type_id = $homeContentType->id;
    $content->published = true;
    $content->save();

    $contentUri = new ContentUri;
    $contentUri->uri = 'home';
    $content->uris()->save($contentUri);

    $contentElement = new ContentElement;
    $contentElement->content_id = $content->id;
    $contentElement->region_id = $taglineRegion->id;
    $contentElement->element_id = $textElement->id;
    $contentElement->element_order = 0;
    $contentElement->save();

    $contentElementRevision = new ContentElementRevision;
    $contentElementRevision->published = true;
    $contentElementRevision->lang = 'en';
    $contentElement->revisions()->save($contentElementRevision);

    $contentElementRevisionValue = new ContentElementRevisionValue;
    $contentElementRevisionValue->field_id = $textElementField->id;
    $contentElementRevisionValue->value = 'Helping America\'s Kids Have a Brighter Future';
    $contentElementRevision->values()->save($contentElementRevisionValue);
  }

}