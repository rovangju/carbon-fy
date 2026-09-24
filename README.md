# Carbon Extension: Fiscal Year (FY)

[![Tests](https://github.com/rovangju/carbon-fy/actions/workflows/tests.yml/badge.svg)](https://github.com/rovangju/carbon-fy/actions/workflows/tests.yml)

-------

Don't reinvent the wheel on that funky date logic to determine what fiscal year it is, or what fiscal year something happened in. 
This simple package has your back!

## Requirements

- PHP 8.1 or later
- Carbon 3


## Overview
The ideal usage scenario would be to use a single instance of the calculator, as most organizations observe a single FY 
for their accounting.

Usage is pretty straight forward:

### Basic usage ###
```php

use CarbonExt\FiscalYear\Calculator;

$c = new Calculator(7, 1); /* FY starts on July 1 */

$c->get(new Carbon('2015-01-01')); /* 2015-06-30 */
$c->get(new Carbon('2015-07-01')); /* 2016-06-30 */

```
