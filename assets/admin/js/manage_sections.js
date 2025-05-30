"use strict";
document.addEventListener('DOMContentLoaded', function () {
    // Array of sortable elements to initialize
    const sortableElements = [
        {
            id: 'sortable-left',
            group: {
                name: 'shared',
                pull: 'clone' // Allow items to be pulled (cloned) from this group
            },
            onEnd: function (evt) {
                console.log('Moved item in left list: ', evt);
                updateOrder(); // Update item order when dragged
            }
        },
        {
            id: 'sortable-right',
            group: {
                name: 'shared',
                pull: 'clone',
                put: false // Prevent items from being placed in this list
            },
            onEnd: function (evt) {
                console.log('Moved item from right to left: ', evt);
                let item = evt.item;
                let newItem = createSectionCard(item); // Create new section card
                newItem.setAttribute('data-order', getNewOrder()); // Set new order for the item

                // Update the hidden inputs for order and type
                let newOrderInput = newItem.querySelector('input.section_order');
                let newTypeInput = newItem.querySelector('input.section_type');
                if (newOrderInput) newOrderInput.value = newItem.getAttribute('data-order');
                if (newTypeInput) newTypeInput.value = newItem.getAttribute('data-type');

                document.getElementById('sortable-left').appendChild(newItem); // Add new item to left container
                item.remove(); // Remove the original item from right container
                updateOrder(); // Update item order after moving
            }
        }
    ];

    // Initialize all sortable elements from the array
    sortableElements.forEach(config => {
        new Sortable(document.getElementById(config.id), {
            group: config.group,
            animation: 150,
            handle: '.sortable-item',
            onStart(evt) {
                console.log('Dragging started:', evt);
            },
            onEnd: config.onEnd // Trigger onEnd callback when drag ends
        });
    });
});

// Function to get the next available order for a new item
function getNewOrder() {
    let sections = document.querySelectorAll('#sortable-left .section-item');
    return sections.length + 1; // New order is the current number of items + 1
}

// Update the order of items in the left container
function updateOrder() {
    let sections = document.querySelectorAll('#sortable-left .section-item');
    sections.forEach((section, index) => {
        section.setAttribute('data-order', index + 1); // Update the data-order attribute

        // Update the section type input
        let typeInput = section.querySelector('.section_type');
        if (typeInput) {
            typeInput.value = section.getAttribute('data-type');
            typeInput.name = `sections[${index + 1}][section_type]`; // Update the name attribute of type input
        }

        // Update names for other form fields inside the section
        updateInputNames(section, index + 1);
    });
}

// Update the 'name' attributes for all input fields inside the section
function updateInputNames(section, order) {
    let inputs = section.querySelectorAll('input, textarea, select'); // Select all input types
    inputs.forEach(input => {
        let name = input.name;

        // If name contains 'sections' and 'fields', update to match the new order
        if (name && name.includes('sections') && name.includes('fields')) {
            input.name = name.replace(/\[default_form\]\[fields\]|\[\d+\]\[fields\]/g, `[${order}][fields]`); // Update name with new order
        }
    });
}

// Create a new "card" for a section when dragged
function createSectionCard(item) {
    let newItem = document.createElement('div');
    newItem.classList.add('section-item');
    newItem.setAttribute('data-type', item.dataset.type);

    let cardContainer = document.createElement('div');
    cardContainer.classList.add('card');

    // Generate a unique ID for the collapse element
    let collapseId = 'collapse-' + new Date().getTime();
    let cardBody = item.querySelector('.card-body').cloneNode(true);
    cardBody.id = collapseId;
    cardBody.classList.remove('d-none');

    let cardHeader = document.createElement('div');
    cardHeader.classList.add('card-header');
    cardHeader.innerHTML = `
        <h3 class="card-title sortable-item"><i class="fe fe-move"></i> ${item.querySelector('.card-title').textContent}</h3>
        <div class="card-options">
            <a href="#" class="card-options-collapse" data-toggle="collapse" data-target="#${collapseId}">
                <i class="fe fe-chevron-up"></i>
            </a>
            <a class="remove-btn" onclick="removeItem(event)"><i class="fe fe-x"></i></a>
        </div>
    `;

    newItem.appendChild(cardHeader);
    newItem.appendChild(cardBody);
    return newItem;
}

// Remove the selected item from the list
function removeItem(event) {
    const itemToRemove = event.target.closest('.section-item');
    itemToRemove.remove(); // Remove item from DOM
}

