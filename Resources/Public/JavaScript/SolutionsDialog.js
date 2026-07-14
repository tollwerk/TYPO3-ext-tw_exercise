/**
 * Accessible SolutionsDialog (modal) that shows given answers, correct answers and points
 * @see https://www.smashingmagazine.com/2021/07/accessible-dialog-from-scratch/
 */
class SolutionsDialog {
    /**
     * Constructor
     *
     * @param {HTMLElement} solutionsDialog - The dialog element.
     * @param {HTMLElement} cloze - The cloze element containing the answers.
     */
    constructor(solutionsDialog, cloze) {
        this.solutionsDialog = solutionsDialog;
        this.shown = false;
        this.dialogId = this.solutionsDialog.id;
        this.dialogOpener = document.querySelector(`[data-dialog-open="${this.dialogId}"]`);
        this.dialogCloser = document.querySelectorAll(`[data-dialog-close="${this.dialogId}"]`);
        this.focusableElements = Array.from(this.solutionsDialog.querySelectorAll('button'));
        this.firstFocusableElement = this.focusableElements[0];
        this.lastFocusableElement = this.focusableElements[this.focusableElements.length - 1];
        this.cloze = cloze;

        // Set accessibility attributes
        this.solutionsDialog.setAttribute('aria-hidden', 'true');
        this.solutionsDialog.setAttribute('aria-modal', 'true');
        this.solutionsDialog.setAttribute('tabindex', '-1');

        if (!this.solutionsDialog.hasAttribute('role')) {
            this.solutionsDialog.setAttribute('role', 'dialog');
        }

        // Event listeners for opening and closing the dialog
        this.dialogOpener.addEventListener('click', () => this.openDialog());
        this.dialogCloser.forEach((el) => {
            el.addEventListener('click', () => this.closeDialog());
        });
        this.solutionsDialog.addEventListener('keydown', this.bindKeyPress.bind(this));
    }

    /**
     * Show the dialog element
     * @return {this}
     */
    openDialog() {
        if (this.shown) return this;
        this.shown = true;

        this.calculatePoints();
        this.solutionsDialog.showModal();
        this.solutionsDialog.removeAttribute('aria-hidden');
        this.solutionsDialog.focus();
    }

    /**
     * Calculate points based on given and correct answers.
     */
    calculatePoints() {
        const givenAnswers = this.cloze.querySelectorAll('[data-select-element]:not([data-select-example])');
        const selectedOptions = [];

        // Extract selected options from given answers
        givenAnswers.forEach((givenAnswer) => {
            const { selectedIndex } = givenAnswer;
            const selectedOption = givenAnswer.options[selectedIndex];
            selectedOptions.push(selectedOption);
        });

        const givenAnswersEl = this.cloze.querySelectorAll('[data-given-answer]');
        // Check if array lengths are the same to avoid out-of-bound errors
        if (selectedOptions.length !== givenAnswersEl.length) {
            return;
        }

        // Display given answers in solutions table
        for (let i = 0; i < givenAnswersEl.length; i++) {
            givenAnswersEl[i].textContent = selectedOptions[i].dataset.optionText.trim();
        }

        const correctAnswers = this.solutionsDialog.querySelectorAll('*[data-correct-answer]');
        const pointsPerAnswer = parseFloat(this.solutionsDialog.querySelector('[data-points-per-answer]').dataset.pointsPerAnswer);
        const pointsMultiplier = parseFloat(this.solutionsDialog.querySelector('[data-points-multiplier]').dataset.pointsMultiplier);
        const currentPoints = this.solutionsDialog.querySelector('[data-current-points]');

        let totalPoints = 0;

        // Calculate and display points for correct answers
        for (let i = 0; i < correctAnswers.length; i++) {
            const pointsForAnswerEl = correctAnswers[i].nextElementSibling;
            let pointsForAnswer = 0;

            if (correctAnswers[i].dataset.correctAnswer === selectedOptions[i].dataset.option) {
                pointsForAnswer = pointsPerAnswer * pointsMultiplier;
                totalPoints += pointsPerAnswer * pointsMultiplier;
            }

            pointsForAnswerEl.textContent = `${pointsForAnswer}`;
            pointsForAnswerEl.dataset.points = `${pointsForAnswer}`;
            currentPoints.textContent = `${totalPoints}`;
            currentPoints.dataset.currentPoints = `${totalPoints}`;
        }
    }

    /**
     * Hide the dialog element
     * @param {Event} event
     * @return {this}
     */
    closeDialog() {
        if (!this.shown) return this;
        this.shown = false;

        this.solutionsDialog.close();
        this.solutionsDialog.setAttribute('aria-hidden', 'true');
        this.dialogOpener.focus();
    }

    /**
     * Handles key presses for escape and tab keys.
     * @param {KeyboardEvent} event - The keydown event.
     */
    bindKeyPress(event) {
        // Closes the dialog if the Escape key is pressed
        if (this.shown && (event.key === 'Escape' || event.key === '27')) {
            event.preventDefault();
            this.closeDialog();
        }

        if (this.shown && (event.key === 'Tab' || event.key === '9')) {
            this.trapTabKey(event);
        }
    }

    /**
     * Traps the focus within the dialog when tabbing.
     * @param {KeyboardEvent} event - The keydown event.
     */
    trapTabKey(event) {
        const focusedItemIndex = this.focusableElements.indexOf(document.activeElement);

        // Move focus to the last element if Shift+Tab on the first element
        if (event.shiftKey && focusedItemIndex === 0) {
            this.lastFocusableElement.focus();
            event.preventDefault();
            // Move focus to the first element if Tab on the last element
        } else if (
            !event.shiftKey
            && focusedItemIndex === this.focusableElements.length - 1
        ) {
            this.firstFocusableElement.focus();
            event.preventDefault();
        }
    }
}

// Initialize all SolutionsDialogs.
const solutionsDialogs = document.querySelectorAll('[data-solutions-dialog]');
solutionsDialogs.forEach((solutionsDialog) => {
    const cloze = solutionsDialog.closest('[data-cloze]');
    new SolutionsDialog(solutionsDialog, cloze);
});
