jQuery(document).ready(function ($, undefined) {
    // Feather Icons
    feather.replace()

// SimpleMDE - Markdown Editor
    let $editors = document.querySelectorAll(".editor")
    let simplemdes = []

    $editors.forEach((element) => {
        simplemdes.push(new SimpleMDE({
            element: element,
            forceSync: true,
            hideIcons: [
                "image",
                "side-by-side",
                "preview"
            ],
            showIcons: [
                "code",
                "table"
            ]
        }))
    })

// Delete Modal
    let modalTriggers = $('[data-modal="confirm-delete"]')

    modalTriggers.on('click', (event) => {
        event.preventDefault()

        if (confirm('Are you sure you want to delete this item?')) {
            window.location = $(event.target).closest('a').prop('href')
        }
    })
})