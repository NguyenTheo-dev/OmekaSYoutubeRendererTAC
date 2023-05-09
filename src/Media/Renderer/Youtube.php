<?php
namespace OmekaSYoutubeRendererTAC\Media\Renderer;

use Omeka\Api\Representation\MediaRepresentation;
use Omeka\Media\Renderer\RendererInterface;
use Laminas\Uri\Http as HttpUri;
use Laminas\View\Renderer\PhpRenderer;

class Youtube implements RendererInterface
{
    const WIDTH = 420;
    const HEIGHT = 315;
    const ALLOWFULLSCREEN = true;

    public function render(PhpRenderer $view, MediaRepresentation $media,
        array $options = []
    ) {
        if (!isset($options['width'])) {
            $options['width'] = self::WIDTH;
        }
        if (!isset($options['height'])) {
            $options['height'] = self::HEIGHT;
        }

        // Compose the YouTube embed URL and build the markup.
        $data = $media->mediaData();
        $start = 0;
        $end = -1;
        if (isset($data['start'])) {
            $start = $data['start'] ;
        }
        // TODO add proper end support. it works, but we shouldn't add it if it's null or unset
        if (isset($data['end'])) {
            $end = $data['end'] ;
        }
        // Building the TAC div. Less preparation is needed, as TAC does most of the work.
        // I think the fullscreen option isn't supported anymore
        $embed = sprintf(
            '<div class="youtube_player" videoID="%s" width="%s" height="%s" theme="dark" 
            rel="0" controls="1" showinfo="1" autoplay="0" start="%s" end="%s"
            mute="0" loop="0" loading="1"></div>',
            $view->escapeHtml($data['id']),
            $view->escapeHtml($options['width']),
            $view->escapeHtml($options['height']),
            $view->escapeHtml($start),
            $view->escapeHtml($end)
        );

        return $embed;
    }
}
