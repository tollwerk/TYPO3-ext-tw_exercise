# tollwerk Exercises

[![TYPO3](https://img.shields.io/badge/TYPO3-13.4-green.svg)](https://get.typo3.org/version/12)
[![License](https://img.shields.io/badge/License-GPL3-blue.svg)](https://opensource.org/license/gpl-3.0)

TYPO3 extension that adds content elements for different kind of exercises like clozes, multiple choice tests etc.

## Installation

1. Install the extension with composer.
    ```
    composer require tollwerk/tw-exercise
    ```

## Available exercises

### Cloze

A fill-in-the-blanks exercise. You enter the text using a simple format to mark gaps and related context.

```
There are many stars in the sky. {{The star closest to us is our own Sun. Next is [[Alpha Centauri]]. 
It is one of the most famous stars in pop culture.}}
```

#### Format

A gap is indicated by a pair of square brackets, `[[` and `]]`. The word that is the correct answer for that blank must 
be placed inside them.

Each gap requires additional context that is crucial for answering the gap. This context is enclosed in double curly 
braces `{{` and `}}`. This ensures that all text before and/or after the square brackets is used as an additional 
description for the actual gap.

Please note: For each cloze, the actual content within a blank (between the square brackets) must be unique! The same 
word cannot appear in multiple gaps. The content of the gaps is case-sensitive, so “abc” and “ABC” are not the same.
Leading or trailing spaces around the content of a gap are ignored.

#### Gap configurations

For each gap within your text you have to add a configuration below your text field. Required information about the gap 
like the available answers must be set. Gaps without a corresponding configuration will be ignored. 

