/**
 * Interactive Cloze with corresponding ClozeSolutionsTable
 */
class Cloze {
    /**
     * Constructor
     *
     * @param {HTMLElement} clozeElement The Cloze element.
     */
    constructor(clozeElement) {
        this.clozeElement = clozeElement;
        this.id = this.clozeElement.id;
        this.selects = this.clozeElement.querySelectorAll('[data-select-element]');

        // Initialize select fields with event listeners for dynamic labeling
        this.selects.forEach((select) => {
            const ariaLabel = select.getAttribute('aria-label');
            select.dataset.ariaLabel = ariaLabel; // Store the original aria-label for later use

            select.addEventListener('focus', this.handleFocus, false);
            select.addEventListener('change', this.handleChange, false);
            select.addEventListener('blur', this.handleBlur, false);
        });

        // Add individual key from options to correct answer in solutions table
        const options = this.getOptions();
        const correctAnswers = this.clozeElement.querySelectorAll('[data-correct-answer]');
        correctAnswers.forEach((correctAnswer) => {
            const correctAnswerText = correctAnswer.dataset.correctAnswer;
            const matchingOption = options.find((option) => option.value === correctAnswerText);

            if (matchingOption) {
                correctAnswer.textContent = `${matchingOption.key}: ${matchingOption.value}`;
            }
        });
    }

    /**
     * Extracts the options of all select elements and returns them as an array of objects.
     *
     * @returns {Array<Object>} A list of objects containing information about the options of the select elements.
     */
    getOptions() {
        const options = [];
        this.selects.forEach((select) => {
            Array.from(select.options).forEach((option) => {
                if (option.value) {
                    options.push({
                        identifier: select.dataset.identifier,
                        key: option.dataset.key,
                        value: option.dataset.option
                    });
                }
            });
        });
        return options;
    }

    /**
     * Handle focus event
     * @param {Event} event - The focus event.
     */
    handleFocus(event) {
        const select = event.target;
        const { ariaLabel } = select.dataset;
        select.setAttribute(
            'aria-label',
            select.options.selectedIndex ? select.options[select.options.selectedIndex].innerText.trim() : ariaLabel
        );
        select.setAttribute('aria-labelledby', select.getAttribute('data-labelledby'));
    }

    /**
     * Handle change event
     * @param {Event} event - The change event.
     */
    handleChange(event) {
        const select = event.target;
        const { ariaLabel } = select.dataset;
        select.setAttribute(
            'aria-label',
            select.options.selectedIndex ? select.options[select.options.selectedIndex].innerText.trim() : ariaLabel
        );
    }

    /**
     * Handle blur event
     * @param {Event} event - The blur event.
     */
    handleBlur(event) {
        const select = event.target;
        select.removeAttribute('aria-label');
        select.removeAttribute('aria-labelledby');
    }
}

// Init all found Cloze elements
const clozes = document.querySelectorAll('[data-cloze]');
clozes.forEach((clozeElement) => {
    new Cloze(clozeElement);
});
