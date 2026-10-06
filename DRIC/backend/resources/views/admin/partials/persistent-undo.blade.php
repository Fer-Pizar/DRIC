<script>
    (() => {
        const form = document.querySelector('form');
        if (!form) return;

        const storageKey = `admin-field-undo:${window.location.pathname}`;
        const startSnapshots = new WeakMap();
        const undoButtonSelector = '[data-undo-card], [data-undo-row], [data-undo-section]';
        const scopeSelector = [
            '[data-undo-scope]',
            '[data-edit-undo-scope]',
            '[data-item-card]',
            '[data-program-card]',
            '[data-call-card]',
            '[data-section-card]',
            '[data-highlight-card]',
            '[data-link-card]',
            '[data-document-card]',
            '[data-opportunity-card]',
            '[data-image-card]',
            '.language-card',
            '.item-card',
            '.program-card',
            '.link-card',
            '.document-row',
            '.news-row',
            '.media-card',
            '.image-card',
            '.membership-row',
            '.certificate-card',
            '.report-card',
            '.social-card',
        ].join(', ');

        const editableSelector = 'input:not([type="file"]):not([type="hidden"]), textarea, select, [contenteditable="true"]';

        function editableFields(scope) {
            return Array.from(scope.querySelectorAll(editableSelector));
        }

        function fieldKey(field) {
            if (field.name) return field.name;
            if (field.dataset.editor) return `editor:${field.dataset.editor}`;
            if (field.id) return `id:${field.id}`;

            const fields = editableFields(scopeFor(field) || form);
            return `index:${fields.indexOf(field)}`;
        }

        function fieldSnapshot(field) {
            const isRichEditor = field.isContentEditable;

            return {
                name: fieldKey(field),
                type: field.type,
                value: isRichEditor ? field.innerHTML : field.value,
                checked: field.checked,
                rich: isRichEditor,
            };
        }

        function snapshotScope(scope) {
            return editableFields(scope)
                .filter((field) => fieldKey(field))
                .map(fieldSnapshot);
        }

        function restoreSnapshot(scope, snapshot) {
            snapshot.forEach((item) => {
                const field = editableFields(scope).find((candidate) => fieldKey(candidate) === item.name);
                if (!field) return;

                if (item.rich || field.isContentEditable) {
                    field.innerHTML = item.value;
                } else if (field.type === 'checkbox' || field.type === 'radio') {
                    field.checked = item.checked;
                } else {
                    field.value = item.value;
                }

                field.dispatchEvent(new Event('input', { bubbles: true }));
                field.dispatchEvent(new Event('change', { bubbles: true }));
            });
        }

        function readHistories() {
            try {
                const stored = sessionStorage.getItem(storageKey);
                const parsed = stored ? JSON.parse(stored) : {};
                return parsed && typeof parsed === 'object' ? parsed : {};
            } catch (error) {
                sessionStorage.removeItem(storageKey);
                return {};
            }
        }

        function writeHistories(histories) {
            const keys = Object.keys(histories).filter((key) => Array.isArray(histories[key]) && histories[key].length);

            if (!keys.length) {
                sessionStorage.removeItem(storageKey);
                return;
            }

            sessionStorage.setItem(storageKey, JSON.stringify(histories));
        }

        function scopeFor(element) {
            return element.closest(scopeSelector);
        }

        function scopeKey(scope) {
            return snapshotScope(scope).map((item) => item.name).join('|');
        }

        function undoButtonFor(scope) {
            return scope.querySelector(undoButtonSelector);
        }

        function pushHistory(scope, snapshot) {
            if (!snapshot.length) return;

            const key = scopeKey(scope);
            if (!key) return;

            const histories = readHistories();
            if (!Array.isArray(histories[key])) histories[key] = [];

            const serialized = JSON.stringify(snapshot);
            const last = histories[key].length ? JSON.stringify(histories[key][histories[key].length - 1]) : null;

            if (serialized !== last) histories[key].push(snapshot);
            if (histories[key].length > 20) histories[key].shift();

            writeHistories(histories);

            const button = undoButtonFor(scope);
            if (button) button.disabled = false;
        }

        function refreshUndoButtons() {
            const histories = readHistories();

            document.querySelectorAll(undoButtonSelector).forEach((button) => {
                const scope = scopeFor(button);
                if (!scope) return;

                const history = histories[scopeKey(scope)];
                if (Array.isArray(history) && history.length) {
                    button.disabled = false;
                }
            });
        }

        document.addEventListener('focusin', (event) => {
            const field = event.target;
            if (!field.matches(editableSelector)) return;

            const scope = scopeFor(field);
            if (!scope || startSnapshots.has(field)) return;

            startSnapshots.set(field, snapshotScope(scope));
        });

        document.addEventListener('input', (event) => {
            const field = event.target;
            const scope = scopeFor(field);
            const snapshot = startSnapshots.get(field);

            if (!scope || !snapshot) return;

            pushHistory(scope, snapshot);
            startSnapshots.delete(field);
        });

        document.addEventListener('change', (event) => {
            const field = event.target;
            const scope = scopeFor(field);
            const snapshot = startSnapshots.get(field);

            if (!scope || !snapshot) return;

            pushHistory(scope, snapshot);
            startSnapshots.delete(field);
        });

        document.addEventListener('click', (event) => {
            const button = event.target.closest(undoButtonSelector);
            if (!button) return;

            const scope = scopeFor(button);
            if (!scope) return;

            const key = scopeKey(scope);
            const histories = readHistories();
            const history = histories[key];

            if (!Array.isArray(history) || !history.length) return;

            event.preventDefault();
            event.stopImmediatePropagation();

            const snapshot = history.pop();
            restoreSnapshot(scope, snapshot);

            if (!history.length) {
                delete histories[key];
                button.disabled = true;
            }

            writeHistories(histories);
        }, true);

        form.addEventListener('submit', () => {
            document.querySelectorAll(editableSelector).forEach((field) => {
                const scope = scopeFor(field);
                const snapshot = startSnapshots.get(field);
                if (scope && snapshot) pushHistory(scope, snapshot);
            });
        });

        refreshUndoButtons();
        window.addEventListener('pageshow', refreshUndoButtons);
    })();
</script>
