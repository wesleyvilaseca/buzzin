const hasWhatsappExtension = (collection) => {
    const TAG = 'whatsapp';
    var hasExtension = collection.some((item) => {
        return item.tag == TAG;
    });

    if (!hasExtension) {
        return false;
    }

    return collection.find(({ tag }) => tag === TAG);
}

export { hasWhatsappExtension };