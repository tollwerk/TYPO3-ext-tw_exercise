/**
 * CSS language mode for the code editor with visual line wrapping, without autocompletion
 * and without automatic indentation on Enter
 */
import {css} from "@codemirror/lang-css";
import {autocompletion} from "@codemirror/autocomplete";
import {HighlightStyle, syntaxHighlighting} from "@codemirror/language";
import {tags as t} from "@lezer/highlight";
import {Prec} from "@codemirror/state";
import {EditorView, keymap} from "@codemirror/view";

/**
 * Syntax highlighting palette — colors not listed here fall back to CodeMirror's defaults,
 * which the core element registers with fallback: true (so our values always win)
 */
const highlightStyle = syntaxHighlighting(
    HighlightStyle.define([
        {tag: t.comment, color: "#000", fontStyle: "normal", fontFamily: "Verdana, Arial, Helvetica, sans-serif"},
        // Element, class and id selectors
        {tag: t.tagName, color: "#000", fontFamily: "Verdana, Arial, Helvetica, sans-serif"},
        {tag: t.className, color: "#000", fontFamily: "Verdana, Arial, Helvetica, sans-serif"},
        {tag: t.constant(t.className), color: "#000", fontFamily: "Verdana, Arial, Helvetica, sans-serif"},
        {tag: t.labelName, color: "#000", fontFamily: "Verdana, Arial, Helvetica, sans-serif"},
        {tag: t.namespace, color: "#000", fontFamily: "Verdana, Arial, Helvetica, sans-serif"},
        {tag: t.attributeName, display: "inline-block", lineHeight: "1.7", padding: "0 7px", color: "#000", fontWeight: "normal", backgroundColor: "#E6E6E6", fontFamily: "Verdana, Arial, Helvetica, sans-serif"},
        // Property names (color, margin, …)
        {tag: t.propertyName, color: "#000", fontFamily: "Verdana, Arial, Helvetica, sans-serif"},
        {tag: t.definition(t.propertyName), color: "#000", fontFamily: "Verdana, Arial, Helvetica, sans-serif"},
        // Values, keywords and at-rules (@media, !important, …)
        {tag: t.keyword, color: "#000", fontFamily: "Verdana, Arial, Helvetica, sans-serif"},
        {tag: t.atom, color: "#000", fontFamily: "Verdana, Arial, Helvetica, sans-serif"},
        {tag: t.modifier, color: "#000", fontFamily: "Verdana, Arial, Helvetica, sans-serif"},
        {tag: t.variableName, color: "#000", fontFamily: "Verdana, Arial, Helvetica, sans-serif"},
        // Numbers, units and hex colors
        {tag: t.number, color: "#000", fontFamily: "Verdana, Arial, Helvetica, sans-serif"},
        {tag: t.unit, color: "#000", fontFamily: "Verdana, Arial, Helvetica, sans-serif"},
        {tag: t.color, color: "#000", fontFamily: "Verdana, Arial, Helvetica, sans-serif"},
        // Strings
        {tag: t.string, color: "#000", fontFamily: "Verdana, Arial, Helvetica, sans-serif"},
        // Function-like values (url(), …)
        {tag: t.operatorKeyword, color: "#000", fontFamily: "Verdana, Arial, Helvetica, sans-serif"},
    ]),
);

const plainNewline = Prec.highest(
    keymap.of([
        {
            key: "Enter",
            run: ({state, dispatch}) => {
                dispatch({...state.replaceSelection("\n"), scrollIntoView: true});
                return true;
            },
        },
    ]),
);

const activeLineStyle = {
    ".cm-activeLine": {
        "background-color": "transparent"
    },
    ".cm-content.cm-lineWrapping": {
        "line-height": 1.7,
        "font-size": "13px"
    },
};

export default function () {
    return [
        css(),
        EditorView.lineWrapping,
        // Empty completion source and no completion keymap (the core "autocompletion"
        // addon registers autocompletion() without options, so these values win)
        autocompletion({override: [], defaultKeymap: false}),
        // Override newlineAndIndent of the default keymap
        plainNewline,
        highlightStyle,
        // Registered twice to cover both the light and the dark (oneDark) color scheme
        EditorView.theme(activeLineStyle),
    ];
}
