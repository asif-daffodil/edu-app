/* global axios */

const MODAL_NAMES = {
    login: 'auth-login',
    register: 'auth-register',
    forgot: 'auth-forgot',
};

function toModalName(keyOrName) {
    return MODAL_NAMES[keyOrName] || keyOrName;
}

function openModal(keyOrName) {
    window.dispatchEvent(new CustomEvent('open-modal', { detail: toModalName(keyOrName) }));
}

function closeModal(keyOrName) {
    window.dispatchEvent(new CustomEvent('close-modal', { detail: toModalName(keyOrName) }));
}

function setAlert(root, message, variant = 'info') {
    const alert = root.querySelector('[data-auth-alert]');
    if (!alert) return;

    alert.classList.remove('hidden');
    alert.textContent = message || '';

    // Minimal variant styling hooks (optional)
    alert.dataset.variant = variant;
}

function clearAlert(root) {
    const alert = root.querySelector('[data-auth-alert]');
    if (!alert) return;

    alert.classList.add('hidden');
    alert.textContent = '';
    delete alert.dataset.variant;
}

function clearErrors(root) {
    root.querySelectorAll('[data-auth-error-for]').forEach((el) => {
        el.textContent = '';
    });
}

function showErrors(root, errors) {
    if (!errors) return;

    Object.entries(errors).forEach(([field, messages]) => {
        const target = root.querySelector(`[data-auth-error-for="${field}"]`);
        if (!target) return;
        const list = Array.isArray(messages) ? messages : [String(messages)];
        target.textContent = '';
        list.forEach((m) => {
            const div = document.createElement('div');
            div.textContent = m;
            target.appendChild(div);
        });
    });
}

function isAjaxAuthRequest(form) {
    return !!form?.dataset?.authForm;
}

function normalizeRedirectTo(value) {
    if (!value) return '';
    const s = String(value).trim();
    if (!s) return '';

    // Keep redirects same-origin.
    try {
        const url = new URL(s, window.location.origin);
        if (url.origin !== window.location.origin) return '';
        return url.pathname + url.search + url.hash;
    } catch (e) {
        return '';
    }
}

function setRedirectToForAuthForms(redirectTo) {
    const normalized = normalizeRedirectTo(redirectTo);
    window.__authRedirectTo = normalized;

    document.querySelectorAll('form[data-auth-form="login"], form[data-auth-form="register"]').forEach((form) => {
        const input = form.querySelector('input[name="redirect_to"], [data-auth-redirect-to]');
        if (!input) return;
        input.value = normalized;
    });
}

async function submitAuthForm(form) {
    const modalRoot = form.closest('[data-auth-modal]') || form;
    const submitBtn = form.querySelector('[data-auth-submit]');

    clearAlert(modalRoot);
    clearErrors(modalRoot);

    if (!window.axios) {
        setAlert(modalRoot, 'AJAX is not available. Please refresh.', 'error');
        return;
    }

    const action = form.getAttribute('action');
    const formData = new FormData(form);

    const originalText = submitBtn?.textContent;
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = submitBtn.dataset.loadingText || 'Please wait...';
    }

    try {
        const response = await axios.post(action, formData, {
            headers: {
                'Accept': 'application/json',
            },
        });

        const data = response?.data || {};

        if (form.dataset.authForm === 'forgot') {
            setAlert(modalRoot, data.message || 'Reset link sent.', 'success');
            return;
        }

        // Login/register: redirect or reload
        const redirectTo = data.redirect;
        if (redirectTo) {
            window.location.assign(redirectTo);
            return;
        }

        closeModal(form.dataset.authForm);
        window.location.reload();
    } catch (err) {
        const status = err?.response?.status;
        const data = err?.response?.data;

        if (status === 422) {
            showErrors(modalRoot, data?.errors);
            setAlert(modalRoot, data?.message || 'Please fix the errors and try again.', 'error');
            return;
        }

        const message = data?.message || 'Something went wrong. Please try again.';
        setAlert(modalRoot, message, 'error');
    } finally {
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText || submitBtn.textContent;
        }
    }
}

function openFromUrlOrFlash() {
    const params = new URLSearchParams(window.location.search);
    const fromQuery = params.get('auth');
    const fromFlash = window.__authModalToOpen;

    const redirectFromQuery = params.get('redirect_to');
    if (redirectFromQuery) {
        setRedirectToForAuthForms(redirectFromQuery);
    }

    const target = fromFlash || fromQuery;
    if (!target) return;

    openModal(target);
}

document.addEventListener('click', (event) => {
    const trigger = event.target?.closest?.('[data-auth-trigger]');
    if (trigger) {
        event.preventDefault();

        if (trigger.dataset.authRedirect) {
            setRedirectToForAuthForms(trigger.dataset.authRedirect);
        }

        openModal(trigger.dataset.authTrigger);
        return;
    }

    const switcher = event.target?.closest?.('[data-auth-switch]');
    if (switcher) {
        event.preventDefault();
        const target = switcher.dataset.authSwitch;

        // Close all and open target to avoid stacked modals
        Object.keys(MODAL_NAMES).forEach((k) => closeModal(k));
        openModal(target);

        if (window.__authRedirectTo) {
            setRedirectToForAuthForms(window.__authRedirectTo);
        }
        return;
    }
});

document.addEventListener('submit', (event) => {
    const form = event.target;
    if (!(form instanceof HTMLFormElement)) return;
    if (!isAjaxAuthRequest(form)) return;

    event.preventDefault();
    submitAuthForm(form);
});

// Auto-open on initial load
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', openFromUrlOrFlash);
} else {
    openFromUrlOrFlash();
}

// Expose for debugging
window.__openAuthModal = openModal;
