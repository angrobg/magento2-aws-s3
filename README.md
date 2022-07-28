Shinetech AWS S3 Extension
===================

Shinetech's AWS S3 extension for Magento 2 allows retailers to upload their catalogue and WYSIWYG images straight to Amazon S3.

Benefits
--------

### Easy to use

This extension is easy to use with little configuration! You only need to follow a few simple steps (and one of them is simply to create a copy of your images as a precaution) to get up and running!

### Sync all your media images

The following images are automatically saved to S3:

* Product images
* Generated thumbnails
* WYSIWYG images
* Category images

### Magento can now scale horizontally

Complex file syncing between multiple servers is now a thing of the past with this extension. All your servers will be able to share the one S3 bucket as the single source of media.

### Easy integration with CloudFront CDN

CloudFront CDN supports using S3 as an origin server so you can significantly reduce load on your servers.

Installation
------------
Run following command

```bash
composer require shinetech/module-aws-s3
php bin/magento module:enable ST_AwsS3
php bin/magento setup:upgrade
```

Go to Stores -> Configuration -> Shinetech EXTENSIONS, enter s3 information.

Go to Stores -> Configuration -> Advanced -> System -> Media Storage, change to Amazon S3 and press Synchronize.

Go to Stores -> Configuration -> General -> Web. Change the Base URL for User Media Files and Secure Base URL for User Media Files to s3 url or cloud front url.

Support
-------

We have a [Troubleshooting](https://github.com/shinetechmagento/magento2-aws-s3/wiki/Troubleshooting) page on our wiki that we'll keep up to date with any issues that the community might have with the extension.

If you can't find the answer you're looking for, however, feel free to [create a GitHub issue](https://github.com/shinetechmagento/magento2-aws-s3/issues/new) or [send us an email](mailto:sunf@shinetechsoftware.com) for support regarding this extension.

### Does this extension upload my log files?

No, the S3 extension only syncs across the media folder. You will need to find an alternative solution to store your log files.

### We did something wrong and all our images are gone! Can you restore it?

We always recommend taking a backup of your media files when switching file storage systems. Unfortunately, we won’t be able to restore images if you somehow accidentally delete them.
