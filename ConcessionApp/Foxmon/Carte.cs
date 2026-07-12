using System;
using System.Collections.Generic;
using System.Data;

namespace projetFoxmon
{
        public class Carte
    {
        private char[,] grille;

        public int Largeur { get; private set; }
        public int Hauteur { get; private set; }

        public Carte(int largeur = 2, int hauteur = 2)
        {
            Largeur = largeur;
            Hauteur = hauteur;
            string[] lignes = new string[]
            {
            "####################",
            "#.........*....*...#",
            "#..####....####..*.#",
            "#.....*.....*......#",
            "#####..####..####..#",
            "#....*....#...*....#",
            "#......####........#",
            "#....#......#......#",
            "#..*.........*.....#",
            "####################",
            };

            Hauteur = lignes.Length;
            Largeur = lignes[0].Length;

            grille = new char[Largeur, Hauteur];

            for (int y = 0; y < Hauteur; y++)
            {
                for (int x = 0; x < Largeur; x++)
                {
                    grille[x, y] = lignes[y][x];
                }
            }
        }

        public void Afficher()
        {
            for (int y = 0; y < Hauteur; y++)
            {
                for (int x = 0; x < Largeur; x++)
                {
                    Console.Write(grille[x, y]);
                }
                Console.WriteLine();
            }
        }

        public bool EstTraversable(int x, int y)
        {
            if (x < 0 || y < 0 || x >= Largeur || y >= Hauteur || (grille[x, y] == '#'))
            {
                return false;
            }
            else
            {
                return true;
            }
        }

        public bool EstHauteHerbe(int x, int y)
        {
            if (x < 0 || y < 0 || x >= Largeur || y >= Hauteur)
            {
                return true;
            }
                return grille[x,y] == '*';
        }
    }
}