feather.replace();

let $editors = document.querySelectorAll(".editor")
let simplemdes = [];

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