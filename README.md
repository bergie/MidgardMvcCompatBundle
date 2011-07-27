# Symfony2 Midgard MVC Compatibility Bundle

This bundle has been created to allow running [Midgard MVC](https://github.com/midgardproject/midgardmvc_core) components and applications under Symfony2.

Note: this is still under heavy development.

## Installation

Install this bundle by adding the following to the `deps` file and running `php bin/vendors install`:

    [MvcCompatBundle]
        git=git://github.com/bergie/MidgardMvcCompatBundle.git
        target=Midgard/MvcCompatBundle

Then add the `Midgard` namespace to the `app/autoload.php`:

    'Midgard' => __DIR__.'/../vendor'

And enable this bundle in your Kernel:

    new Midgard\MvcCompatBundle\MidgardMvcCompatBundle()

## Configuration

You need to tell the MvcCompat autoloader where your Midgard MVC components are installed.

Do this by editing your `config.yml`. If your components are installed in the `midgardmvc` directory under Symfony2 root, then:

    midgard_mvc_compat:
        root: "%kernel.root_dir%/../midgardmvc"

## Running components in your Symfony2 application

You can run individual components by adding them to your route configuration. For example:

    _projectsite:
        resource: "org_midgardproject_projectsite"
        prefix: /midgard
        type: midgardmvc

If your components need a Midgard2 repository connection, ensure that you also have the [MidgardConnectionBundle](https://github.com/bergie/MidgardConnectionBundle) installed and configured.
