<?php

namespace Tests\Feature;

use App\Http\Resources\MediaAssetResource;
use App\Models\MediaAsset;
use Illuminate\Http\Request;
use Tests\TestCase;

class MediaAssetUrlTest extends TestCase
{
    public function test_public_media_url_uses_the_configured_disk_url(): void
    {
        config()->set('filesystems.disks.public.url', 'https://dric-admin.example.edu/storage');

        $media = new MediaAsset([
            'file_path' => 'news/example.jpg',
            'disk' => 'public',
        ]);

        $url = (new MediaAssetResource($media))
            ->toArray(Request::create('http://dric-admin.example.edu/api/pages/noticias'))['url'];

        $this->assertSame('https://dric-admin.example.edu/storage/news/example.jpg', $url);
    }
}
