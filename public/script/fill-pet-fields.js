document.getElementById("pet_species").addEventListener("change", e => {
    let selectIndex = e.target.selectedIndex;
    let infos = e.target.options[selectIndex].dataset.infos;
    infos = JSON.parse(infos)

    document.getElementById('pet_pvMax').value = infos.pv
    document.getElementById('pet_pcMax').value = infos.pc
    document.getElementById('pet_pmMax').value = infos.pm

    document.getElementById('pet_level').value = infos.level
    document.getElementById('pet_physicalAbsorption').value = infos.physicalAbsorption
    document.getElementById('pet_magicalAbsorption').value = infos.magicalAbsorption

    document.getElementById('pet_constitution').value = infos.constitution
    document.getElementById('pet_strength').value = infos.strength
    document.getElementById('pet_dexterity').value = infos.dexterity
    document.getElementById('pet_intelligence').value = infos.intelligence
    document.getElementById('pet_charisma').value = infos.charisma
    document.getElementById('pet_faith').value = infos.faith
})
