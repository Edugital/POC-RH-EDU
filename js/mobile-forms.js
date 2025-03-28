// Mobile Form Handler
class MobileFormHandler {
    constructor() {
        this.forms = document.querySelectorAll('form');
        this.init();
    }
    
    init() {
        this.forms.forEach(form => {
            this.setupForm(form);
        });
    }
    
    setupForm(form) {
        // Add mobile-specific attributes
        this.addMobileAttributes(form);
        
        // Setup input interactions
        this.setupInputInteractions(form);
        
        // Setup validation
        this.setupValidation(form);
        
        // Setup file inputs
        this.setupFileInputs(form);
        
        // Setup select inputs
        this.setupSelectInputs(form);
    }
    
    addMobileAttributes(form) {
        // Add data-mobile attribute for styling
        form.setAttribute('data-mobile', 'true');
        
        // Add autocomplete attributes
        const inputs = form.querySelectorAll('input');
        inputs.forEach(input => {
            if (!input.hasAttribute('autocomplete')) {
                switch (input.type) {
                    case 'email':
                        input.setAttribute('autocomplete', 'email');
                        break;
                    case 'tel':
                        input.setAttribute('autocomplete', 'tel');
                        break;
                    case 'password':
                        input.setAttribute('autocomplete', 'current-password');
                        break;
                    case 'text':
                        if (input.name.includes('name')) {
                            input.setAttribute('autocomplete', 'name');
                        }
                        break;
                }
            }
        });
    }
    
    setupInputInteractions(form) {
        const inputs = form.querySelectorAll('input, textarea, select');
        
        inputs.forEach(input => {
            // Add focus styles
            input.addEventListener('focus', () => {
                input.closest('.form-group').classList.add('focused');
            });
            
            input.addEventListener('blur', () => {
                input.closest('.form-group').classList.remove('focused');
            });
            
            // Handle input events
            input.addEventListener('input', () => {
                this.handleInput(input);
            });
            
            // Handle change events
            input.addEventListener('change', () => {
                this.handleChange(input);
            });
        });
    }
    
    setupValidation(form) {
        // Add validation attributes
        const inputs = form.querySelectorAll('input, textarea, select');
        
        inputs.forEach(input => {
            // Add required validation
            if (input.hasAttribute('required')) {
                input.addEventListener('invalid', (e) => {
                    e.preventDefault();
                    this.showValidationError(input, 'Este campo é obrigatório');
                });
            }
            
            // Add pattern validation
            if (input.hasAttribute('pattern')) {
                input.addEventListener('input', () => {
                    const pattern = new RegExp(input.getAttribute('pattern'));
                    if (!pattern.test(input.value)) {
                        this.showValidationError(input, 'Formato inválido');
                    } else {
                        this.hideValidationError(input);
                    }
                });
            }
            
            // Add min/max validation
            if (input.hasAttribute('min') || input.hasAttribute('max')) {
                input.addEventListener('input', () => {
                    const min = input.getAttribute('min');
                    const max = input.getAttribute('max');
                    const value = parseFloat(input.value);
                    
                    if (min && value < parseFloat(min)) {
                        this.showValidationError(input, `Valor mínimo: ${min}`);
                    } else if (max && value > parseFloat(max)) {
                        this.showValidationError(input, `Valor máximo: ${max}`);
                    } else {
                        this.hideValidationError(input);
                    }
                });
            }
        });
        
        // Handle form submission
        form.addEventListener('submit', (e) => {
            if (!this.validateForm(form)) {
                e.preventDefault();
            }
        });
    }
    
    setupFileInputs(form) {
        const fileInputs = form.querySelectorAll('input[type="file"]');
        
        fileInputs.forEach(input => {
            // Add custom file input UI
            this.createCustomFileInput(input);
            
            // Handle file selection
            input.addEventListener('change', () => {
                this.handleFileSelection(input);
            });
        });
    }
    
    setupSelectInputs(form) {
        const selectInputs = form.querySelectorAll('select');
        
        selectInputs.forEach(select => {
            // Add mobile-friendly select UI
            this.createMobileSelect(select);
            
            // Handle selection
            select.addEventListener('change', () => {
                this.handleSelectChange(select);
            });
        });
    }
    
    handleInput(input) {
        // Remove validation error on input
        this.hideValidationError(input);
        
        // Update character count if maxlength is set
        if (input.hasAttribute('maxlength')) {
            this.updateCharacterCount(input);
        }
    }
    
    handleChange(input) {
        // Handle specific input types
        switch (input.type) {
            case 'file':
                this.handleFileSelection(input);
                break;
            case 'select-one':
                this.handleSelectChange(input);
                break;
            case 'checkbox':
            case 'radio':
                this.handleCheckboxRadioChange(input);
                break;
        }
    }
    
    showValidationError(input, message) {
        const formGroup = input.closest('.form-group');
        let errorElement = formGroup.querySelector('.validation-error');
        
        if (!errorElement) {
            errorElement = document.createElement('div');
            errorElement.className = 'validation-error';
            formGroup.appendChild(errorElement);
        }
        
        errorElement.textContent = message;
        formGroup.classList.add('has-error');
    }
    
    hideValidationError(input) {
        const formGroup = input.closest('.form-group');
        const errorElement = formGroup.querySelector('.validation-error');
        
        if (errorElement) {
            errorElement.remove();
            formGroup.classList.remove('has-error');
        }
    }
    
    validateForm(form) {
        let isValid = true;
        const inputs = form.querySelectorAll('input, textarea, select');
        
        inputs.forEach(input => {
            if (input.hasAttribute('required') && !input.value) {
                this.showValidationError(input, 'Este campo é obrigatório');
                isValid = false;
            }
            
            if (input.hasAttribute('pattern')) {
                const pattern = new RegExp(input.getAttribute('pattern'));
                if (!pattern.test(input.value)) {
                    this.showValidationError(input, 'Formato inválido');
                    isValid = false;
                }
            }
        });
        
        return isValid;
    }
    
    createCustomFileInput(input) {
        const formGroup = input.closest('.form-group');
        const customInput = document.createElement('div');
        customInput.className = 'custom-file-input';
        
        const label = document.createElement('label');
        label.className = 'custom-file-label';
        label.textContent = 'Selecionar arquivo';
        
        const fileName = document.createElement('span');
        fileName.className = 'file-name';
        
        customInput.appendChild(label);
        customInput.appendChild(fileName);
        formGroup.appendChild(customInput);
        
        // Update label on file selection
        input.addEventListener('change', () => {
            const file = input.files[0];
            if (file) {
                fileName.textContent = file.name;
            } else {
                fileName.textContent = '';
            }
        });
    }
    
    createMobileSelect(select) {
        const formGroup = select.closest('.form-group');
        const customSelect = document.createElement('div');
        customSelect.className = 'custom-select';
        
        const label = document.createElement('label');
        label.className = 'custom-select-label';
        label.textContent = select.options[select.selectedIndex].text;
        
        const options = document.createElement('div');
        options.className = 'select-options';
        
        Array.from(select.options).forEach(option => {
            const optionElement = document.createElement('div');
            optionElement.className = 'select-option';
            optionElement.textContent = option.text;
            
            optionElement.addEventListener('click', () => {
                select.value = option.value;
                label.textContent = option.text;
                options.classList.remove('show');
                this.handleSelectChange(select);
            });
            
            options.appendChild(optionElement);
        });
        
        customSelect.appendChild(label);
        customSelect.appendChild(options);
        formGroup.appendChild(customSelect);
        
        // Toggle options on label click
        label.addEventListener('click', () => {
            options.classList.toggle('show');
        });
        
        // Close options when clicking outside
        document.addEventListener('click', (e) => {
            if (!customSelect.contains(e.target)) {
                options.classList.remove('show');
            }
        });
    }
    
    handleFileSelection(input) {
        const file = input.files[0];
        if (file) {
            // Check file size
            const maxSize = input.getAttribute('data-max-size');
            if (maxSize && file.size > maxSize * 1024 * 1024) {
                this.showValidationError(input, `Arquivo muito grande. Tamanho máximo: ${maxSize}MB`);
                input.value = '';
                return;
            }
            
            // Check file type
            const allowedTypes = input.getAttribute('accept');
            if (allowedTypes && !allowedTypes.split(',').some(type => file.type.match(type.trim()))) {
                this.showValidationError(input, 'Tipo de arquivo não permitido');
                input.value = '';
                return;
            }
        }
    }
    
    handleSelectChange(select) {
        const formGroup = select.closest('.form-group');
        const customSelect = formGroup.querySelector('.custom-select');
        if (customSelect) {
            const label = customSelect.querySelector('.custom-select-label');
            label.textContent = select.options[select.selectedIndex].text;
        }
    }
    
    handleCheckboxRadioChange(input) {
        const formGroup = input.closest('.form-group');
        if (input.type === 'checkbox') {
            // Handle checkbox group validation
            const checkboxes = formGroup.querySelectorAll('input[type="checkbox"]');
            const required = checkboxes[0].hasAttribute('required');
            const checked = Array.from(checkboxes).some(cb => cb.checked);
            
            if (required && !checked) {
                this.showValidationError(checkboxes[0], 'Selecione pelo menos uma opção');
            } else {
                this.hideValidationError(checkboxes[0]);
            }
        }
    }
    
    updateCharacterCount(input) {
        const formGroup = input.closest('.form-group');
        let countElement = formGroup.querySelector('.character-count');
        
        if (!countElement) {
            countElement = document.createElement('div');
            countElement.className = 'character-count';
            formGroup.appendChild(countElement);
        }
        
        const maxLength = parseInt(input.getAttribute('maxlength'));
        const currentLength = input.value.length;
        
        countElement.textContent = `${currentLength}/${maxLength}`;
        
        if (currentLength > maxLength) {
            countElement.classList.add('exceeded');
        } else {
            countElement.classList.remove('exceeded');
        }
    }
}

// Initialize mobile form handler when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new MobileFormHandler();
}); 