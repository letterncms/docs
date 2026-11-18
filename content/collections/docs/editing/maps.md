---
id: 01m7p294fzqzan3f1jczg1hjgg
title: Maps
position: 7
description: An open map with pins in your site’s colors or a style of its own, with no account, no key and no cookies.
---
The **Map** block shows where something is: one address, or every office, campus or shop at once. It comes with Lettern. The map is drawn in the visitor's browser from OpenStreetMap, with tiles from [OpenFreeMap](https://openfreemap.org), so there is no account to make, no key to keep and no cookie, and nothing on the page loads the map until it scrolls near.

![A restaurant's Find us page with a Map selected: one pin on the harbour, drawn in the site's colors, and the Map's settings on the right.](/media/screens/editing-maps.webp)

## Places

A Map holds **Place** blocks, one pin each. A Place has a **Location** (its address, and its latitude and longitude, which you can copy from the address bar of [openstreetmap.org](https://www.openstreetmap.org) after zooming in on it), a **Name**, **Details** such as opening hours or a floor, and a **Link** to a page about it. A pin opens a card with all of it and a link to directions on OpenStreetMap.

With one place the map centres on it at the **Zoom** you choose. With more, it shows them all, zoomed in no further than that.

To put a collection on a map, put a **Repeat** inside the Map and a Place inside the Repeat, and bind the Place's Location to the entries' location field: every entry becomes a pin, in the order and with the filters the Repeat has. On an entry's own template, bind a single Place's Location to `entry.location` to show where that one is.

## Styles

**Style** picks one of nine presets:

- **Site Colors**, the default, paints the map in your design's colors: land in its surface color, water and parks tinted with its primary color, names in its muted text color. It follows a section's color scheme and dark mode, so a map on a dark band is a dark map.
- **Light** and **Dark**, quiet maps for any design.
- **Streets** and **Bright**, with every road, path and point of interest in full color.
- **Night**, a deep blue map.
- **Gray**, **Pastel** and **Blueprint**, each a palette of its own.

Under **Design**, **Land Color**, **Water Color**, **Park Color**, **Road Color**, **Label Color** and **Pin Color** set those parts yourself, over any preset. Pins are your primary color unless you choose another. **Aspect Ratio** sets the map's shape, and the map keeps it while it loads, so nothing on the page moves.

## For every visitor

The places are also on the page as text: screen readers read them in place of the map, and **List Places Below** shows them to everyone, under the map. If the map can't load, the list shows by itself. Scrolling the page never zooms the map: on a computer it zooms with Ctrl or ⌘ held, on a phone it moves with two fingers. Turn off **Move and Zoom** for a still map. **Name for Screen Readers** names the map's region, such as "Our campuses".

The builder draws the map as the site will, still, with its places under it to select.

## For developers

```markdown
::: map {"props":{"style":"site","zoom":15,"aspect":"16/9","label":"Our campuses"}}
:::: map-place {"props":{"place":{"lat":51.0543,"lng":3.7174,"address":"Korenmarkt 1, Gent"},"title":"Visitor centre","text":"Every day 9 to 17","url":"/visit"}}
::::
:::
```

`map` takes `style` (`site`, `light`, `dark`, `streets`, `bright`, `night`, `gray`, `pastel`, `blueprint`), `zoom` (2 to 19), `aspect` (`16/9`, `4/3`, `3/2`, `1/1`, `21/9`, `3/4`), `interactive`, `list`, `label`, and the colors `color_land`, `color_water`, `color_park`, `color_road`, `color_label` and `color_pin` as `#rrggbb`. `map-place` takes `place` (`{lat, lng, address}`, the value of a Location field), `title`, `text` and `url`. A Map's children are Places and Repeats; a Place anywhere else shows nothing.

With the [content security policy](/operations/security#content-security-policy) on, a page with a map may connect to `tiles.openfreemap.org`, for its tiles, styles and label fonts. A Google Maps address in an **Embed** block shows nothing: maps are the Map block's.
