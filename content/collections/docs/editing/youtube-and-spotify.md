---
id: 01m7bdhrhs4c0fr2sf2gqv4y1d
title: YouTube and Spotify
position: 5
description: Videos and music from YouTube and Spotify that load only when played, with their own players.
---
YouTube and Spotify are free plugins, each adding one block. Install them from **Plugins**, or with `composer require letterncms/youtube` and `composer require letterncms/spotify`. The core's **Video** and **Embed** blocks keep working without them.

## YouTube

Paste a video's link (from its Share button, the address bar, a Short or an embed link) or its id. The page shows the video's poster with YouTube's play button, and YouTube's player takes its place, already playing, when a visitor presses it. Until then nothing on the page contacts YouTube and no cookie is set. Without JavaScript the poster is a link to the video. Your site asks YouTube once for the video's title and copies its poster, so visitors' browsers don't.

**Start At** takes `90`, `1:30` or `1m30s`; a time in the link (`t=1m30s`) works too. **Aspect Ratio** is automatic: 16:9, and 9:16 for a Short. **Show Subtitles** and **Privacy-Enhanced Mode** are on by default. Turn off **Load When Played** to load the player with the page, or choose a **Poster Image** of your own. A private video, one that is gone, or one its owner keeps off other sites shows nothing, and the block says why on the canvas.

## Spotify

Paste a link to a song, album, playlist, artist, podcast episode or show, or a `spotify:` URI. One thing to play gets the compact player, a list the tall one; **Size** chooses Slim, Compact or Tall instead. **Colors** follows the artwork or stays dark. **Load on Click** shows a card with the title in the player's place and loads the player when it is pressed; it's off by default, since the card can't show the artwork and visitors then press twice. Short `spotify.link` links, your library, and anything private or gone show nothing, and the block says why.

## When a plugin is turned off

Pages keep every YouTube and Spotify block as it is. The site shows nothing in their place, and the editor shows each one as a block whose plugin is off, to move or delete. Turn the plugin on again and they come back unchanged.

## For developers

```markdown
::: youtube/video {"props":{"url":"https://www.youtube.com/watch?v=aqz-KE-bpKQ","start":"0:30"}}
:::

::: spotify/player {"props":{"url":"https://open.spotify.com/playlist/37i9dQZF1DXcBWIGoYBM5M","theme":"dark"}}
:::
```

`youtube/video` takes `url`, `title`, `start`, `aspect` (`auto`, `16/9`, `4/3`, `1/1`, `9/16`), `captions`, `privacy`, `load_on_click` and `poster`. `spotify/player` takes `url`, `title`, `size` (`auto`, `slim`, `compact`, `tall`), `theme` (`auto`, `dark`) and `load_on_click`. With the content security policy on, each plugin allows its own player's frames.
