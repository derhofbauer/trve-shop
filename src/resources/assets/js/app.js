jQuery(document).ready(function ($, undefined) {
    // Go :D
    console.log('GO! :D')

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

    // Dropdown
    $('[data-toggle]').on('click', (event) => {
        event.preventDefault()

        let $target = $(event.currentTarget).attr('data-toggle')

        if ($target != undefined) {
            $($target).slideToggle();
        }
    })

    // Logout Link
    $('[data-logout]').on('click', (event) => {
        event.preventDefault()
        $('#logout-form').submit()
    })

    // Price Range
    $('.price__max').text($('[name="price_max"]').first().val())
    $('[name="price_max"]').on('change', (event) => {
        let $range = $(event.target)
        let val = $range.first().val()
        $('.price__max').text(val)
    })
})