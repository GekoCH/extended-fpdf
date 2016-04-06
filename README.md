# FPDF/FPDI Wrapper

A wrapper for [FPDPF](https://github.com/setasign/fpdf) and [FPDI](https://github.com/Setasign/FPDI).

Extended FPDF with helper methods, defaults to UTF-8. based on [FPDF_EXTENDED](https://github.com/hanneskod/fpdf).

## Install

Via Composer

``` bash
$ composer require Inteleon/extended-fpdf
```

## Usage

When you bootstrap your application create an alias for `fpdi_bridge`

```php
<?php

class_alias('Inteleon\Pdf\Bridge', 'fpdi_bridge');
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
