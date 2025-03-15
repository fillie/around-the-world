import React, { useEffect, useRef } from 'react';
import Globe from 'globe.gl';

interface GlobeComponentProps {
    highlightedCountries: string[]; // List of country ISO_A2 codes to highlight
}

const GlobeComponent: React.FC<GlobeComponentProps> = ({ highlightedCountries = ['GB', 'US', 'FR', 'DE'] }) => {
    const globeRef = useRef<HTMLDivElement>(null);
    const containerRef = useRef<HTMLDivElement>(null);

    useEffect(() => {
        if (!globeRef.current) return;

        const globeInstance = Globe()(globeRef.current)
            .globeImageUrl('//unpkg.com/three-globe/example/img/earth-dark.jpg');

        fetch('https://raw.githubusercontent.com/nvkelso/natural-earth-vector/refs/heads/master/geojson/ne_110m_admin_0_countries.geojson')
            .then(res => res.json())
            .then(countries => {
                globeInstance
                    .polygonsData(countries.features.filter(({ properties: d }) => highlightedCountries.includes(d.ISO_A2)))
                    .polygonCapColor(() => 'rgba(255, 0, 0, 0.8)') // Highlight color
                    .polygonSideColor(() => 'rgba(200, 0, 0, 0.5)') // Side shading
                    .polygonStrokeColor(() => '#ffffff') // Border color
                    .polygonLabel(({ properties: d }) => `
            <b>${d.ADMIN} (${d.ISO_A2})</b> <br />
            Population: <i>${d.POP_EST}</i>
          `);
            });
    }, [highlightedCountries]);

    return (
        <div ref={containerRef} className="flex flex-col md:flex-row h-screen">
            {/* Globe Section */}
            <div className="w-full md:w-2/3 h-2/3 md:h-full flex items-center justify-center bg-black">
                <div ref={globeRef} className="w-full h-full" />
            </div>

            {/* Info Section */}
            <div className="w-full md:w-1/3 h-1/3 md:h-full bg-gray-900 text-white p-4 overflow-auto flex flex-col justify-center">
                <h2 className="text-xl font-bold">Highlighted Countries</h2>
                <ul className="mt-2">
                    {highlightedCountries.map((country, index) => (
                        <li key={index} className="text-lg">{country}</li>
                    ))}
                </ul>
            </div>
        </div>
    );
};

export default GlobeComponent;
