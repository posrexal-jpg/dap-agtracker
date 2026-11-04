# COTS Tracker branding

The app uses `cots_mark.png` as its refreshed icon and renders the COTS Tracker
wordmark as native text. `cots_tracker_logo.png` is retained as the original
reference downloaded from https://cotstracker.com/images/logo.png.

The SLSU and DOST logos (`slsu-logo.png`, `dost-logo.png`) are unmodified copies
of the assets already used by the Laravel website in `public/images/`.
Partnership wording follows that website's SLSU Bontoc–DOST attribution;
the welcome does not assign funding or institutional responsibilities.

The welcome opens once after application initialization. Dismissal is saved
on the device under `partnership_welcome_v1_seen`. Users can reopen it from
the sign-in page, dashboard, app header, or Settings. All logos and welcome
content are bundled and remain available offline.

## Image generation

Tool: built-in ImageGen, editing the original COTS logo with a transparent
background. Final project asset: `assets/images/cots_mark.png`.
The final generated image is retained in this repository as
`assets/images/cots_mark.png`.

Prompt used:

> Use case: logo-brand. Edit the supplied COTS Tracker logo into one polished,
> clean app icon mark for a marine field monitoring Flutter app. Preserve its
> recognizable red/coral location-pin silhouette enclosing a purple
> crown-of-thorns starfish. Simplify the starfish into a crisp, symmetrical
> many-armed spiny marine form that remains readable at small sizes. Refine
> the pin geometry, balanced proportions, clean edges and subtle dimensional
> shading; use restrained deep ocean teal reef/coral accents at the base if
> helpful. Professional, contemporary, vector-like logo finish, minimal and
> confident rather than photorealistic. NO text, NO letters, NO wordmark, NO
> institutional seals, NO added symbols or badge border. The wordmark will
> be typeset separately in the app. One centered isolated icon only, square
> composition, generous transparent safe area around the mark (about 15
> percent each side) for adaptive app icons. Transparent background, preserve
> clean alpha edges. Do not alter or incorporate SLSU or DOST branding.
