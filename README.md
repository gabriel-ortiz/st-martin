# WordPress Starter theme build with Foundation 6

## Wordpress Guidelines

### Framework
Uses JointsWP template with Foundation 6 Framework
Refer to [JointsWP Documentation](http://jointswp.com/docs/) for more information

### Custom Post Types
We use the [extended-cpts library](https://github.com/johnbillion/extended-cpts) to easily create and manage custom post types.

### Custom Taxonomies
We use the [extended-taxos library](https://github.com/johnbillion/extended-taxos) to easily create and manage custom taxonomies.

### Custom fields
We use the [CMB2 library](https://github.com/WebDevStudios/CMB2) to create and manage custom fields in the backend.
Refer to the [CMB2 wiki](https://github.com/WebDevStudios/CMB2/wiki) for documentation.


Currently using Foundation 6.4.3.

## Getting Started

1. Clone or download the repo to your machine.
2. Using the console, navigate to the project folder and run `npm install`.
3. You're all set! Optionally you can do a find a replace for any variables or namespaces if want to change the theme name.

## Working with JointsWP
### Watching for Changes
```bash
$ npm run watch
```
* Watches for changes in the `assets/styles/scss` directory. When a change is made the SCSS files are compiled, concatenated with Foundation files and saved to the `/styles` directory. Sourcemaps will be created.
* Watches for changes in the `assets/scripts/js` directory. When a change is made the JS files are compiled, concatenated with Foundation JS files and saved to the `/scripts` directory. Sourcemaps will be created.
* Watches for changes in the `assets/images` directory. When a change is made the image files are optimized and saved over the original image.

### Watching for Changes with Browsersync
```bash
$ npm run browsersync
```
This will watch the same files as `npm run watch`, but utilizes browsersync for live reloading and style injection. Be sure to update the `URL` variable in the `gulpfile.js` to your local install URL. 

## Compile and Minify All Theme Assets
```bash
$ npm run build
```
Compiles and minifies all scripts and styles.

### Compile Specific Assets
* `$ npm run styles` - to compile all SCSS files in the `assets/styles/scss` directory.
* `$ npm run scripts` - to compile all JS files in the `assets/scripts/js` directory.
* `$ npm run images` - to optimize all image files in the `assets/images` directory.

## File Structure - "Where to Put Stuff"

### Custom Styles
* `style.css` - this file is never actually loaded, however, this is where you set your theme name and is required by WordPress
* `assets/styles/scss/style.scss` - import all of your styles here. If you create an additional SCSS file, be sure to import it here.
* `assets/styles/scss/_main.scss` - place all of your custom styles here.
* `assets/styles/scss/_settings.scss` - adjust Foundation style settings here.
* `assets/styles/scss/login.scss` - place custom login styles here. This will generate it's own stylesheet.
### Custom Scripts
* `assets/scripts/js/` - place your custom scripts here. Each .JS file will be compiled and concatenated when the build process is ran.

### Images
* `assets/images/` - place your theme images here. Each image will be optimized when the build process is ran.

### Vendors CSS
* `assets/styles/vendors/` - place vendor css here, right now we won't be concatenating this with our custom css.

## Vendors JS
* `assets/scripts/vendors` - placer vendor JS here, right now we won't be adding to the main script, be sure to also `wp_register_script`.