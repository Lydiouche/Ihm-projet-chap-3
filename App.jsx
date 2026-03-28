import React, { useState, useEffect } from 'react';
import './Menu.css';

const MenuItem = ({ label, active, onClick }) => {
    return (
        <li className={active ? 'menu-item active' : 'menu-item'} onClick={onClick}>
            {label}
        </li>
    );
};

const Menu = () => {
    const categories = ['Accueil', 'Les maladies', 'Modification des données'];

    const [selectedIndex, setSelectedIndex] = useState(() => {
        const savedIndex = localStorage.getItem('menuIndex');
        return savedIndex !== null ? parseInt(savedIndex) : 0;
    });

    useEffect(() => {
        localStorage.setItem('menuIndex', selectedIndex);
    }, [selectedIndex]);

    return (
        <div>
            <nav className="navbar">
                <ul className="menu-list">
                    {categories.map((cat, index) => (
                        <MenuItem
                            key={cat}
                            label={cat}
                            active={index === selectedIndex}
                            onClick={() => setSelectedIndex(index)}
                        />
                    ))}
                </ul>
            </nav>

            <div className="content-container" style={{ padding: '20px' }}>
                
                {/* --- PAGE ACCUEIL --- */}
                {selectedIndex === 0 && (
                    <div className="home-content">
                        
                        {/* 1. Bloc du haut : Actualités */}
                        <div className="maladies-moment">
                            <h2>Maladies du moment</h2>
                            <p><i>Voici l'état actuel des épidémies surveillées en Mars 2026 :</i></p>
                            <ul>
                                <li>Grippe saisonnière - 🟢 Niveau de base. L'épidémie est officiellement terminée en France métropolitaine depuis la fin février. Les indicateurs sont revenus à leur niveau normal.</li>
                                <li>Bronchiolite : 🟢 Niveau de base. La circulation du virus (VRS) est désormais très faible dans toutes les régions de l'Hexagone.</li>
                                <li>COVID-19 : 🟡 Vigilance faible. La circulation reste présente mais à des niveaux bas et stables. On observe cependant une surveillance accrue des eaux usées.</li>
                                <li>Gastro-entérite : 🟡 Activité modérée. Comme souvent au début du printemps, on observe des foyers locaux, mais pas d'épidémie nationale majeure.</li>
                            </ul>
                        </div>
                        <div className="maladies-moment">
                            <h2>Vigilance Infections à méningocoque</h2>
                            <p><i>Quelques cas isolés ont été signalés récemment (notamment en Normandie), incitant les autorités à rappeler l'importance de la vaccination.</i></p>
                        </div>
                        <div className="maladies-moment">
                            <h2>Attention : retour du pollen !</h2>
                            <p><i>Les allergies saisonnières reviennent avec leur lot de symptômes. N'oubliez pas de consulter un professionnel de santé si les symptômes persistent.</i></p>
                        </div>

                        {/* 2. Bloc du milieu : Conseils de santé */}
                        <section className="health-tips" style={{ marginTop: '30px', backgroundColor: '#f9f9f9', padding: '15px', borderRadius: '8px' }}>
                            <h3>💡 Indications de santé</h3>
                            <p>Pour limiter la propagation des maladies actuelles, nous recommandons :</p>
                            <ul style={{ fontSize: '0.9em', color: '#555' }}>
                                <li><b>Lavage des mains :</b> Essentiel pour freiner la gastro-entérite.</li>
                                <li><b>Aération :</b> Ouvrez les fenêtres 10 min par jour contre la rhinopharyngite.</li>
                                <li><b>Distanciation :</b> Portez un masque en cas de symptômes grippaux.</li>
                            </ul>
                        </section>

                        {/* 3. Bloc du bas : À propos (inversé ici) */}
                        <section className="site-info" style={{ marginTop: '50px', borderTop: '1px solid #eee', paddingTop: '20px' }}>
                            <h2>À propos de notre plateforme</h2>
                            <p>
                                Ce site a été conçu pour offrir un suivi en temps réel de la situation sanitaire. 
                                Notre but est de centraliser les données sur la propagation des virus courants afin de 
                                permettre aux utilisateurs d'adapter leurs comportements et de protéger leurs proches.
                            </p>
                        </section>
                    </div>
                )}

                {/* --- AUTRES PAGES --- */}
                {selectedIndex === 1 && <div>Page : Liste de toutes les maladies</div>}
                {selectedIndex === 2 && <div>Page : Paramètres et modifications</div>}
                
            </div>
        </div>
    );
};

export default Menu;