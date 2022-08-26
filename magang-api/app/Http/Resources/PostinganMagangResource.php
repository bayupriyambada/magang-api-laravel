<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostinganMagangResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'postingan_magang_id'  => $this->postingan_magang_id,
            'judul'  => $this->judul,
            'slug'  => $this->slug,
            'gambar'  => $this->gambar,
            'deskripsi'  => $this->deskripsi,
            'dibuat_pada'  => $this->dibuat_pada,
            'tgl_buka'  => $this->tgl_buka,
            'tgl_tutup'  => $this->tgl_tutup,
            'img_url' => $this->img_url,
            'member_user' => $this->member->fullname,
            'favorit' => $this->favorit->favorit,
            'lokasi' => $this->lokasi->lokasi,
            'kategori' => $this->kategori->kategori,
        ];
    }
}
